# Requirement Module 8: Citizen Grievances Tracker

*Part of the Sachin Khandelwal Portal Requirements Suite.*

---

## 🗺️ Requirements Suite Map

*To easily navigate between functional requirements modules, click any link below:*

* 📄 **[1. Project Overview](./overview.md)** — Core identity, design inspiration, branding guidelines, and mobile-first policies.
* 🌐 **[2. Localization & Language](./localization.md)** — Multilingual configuration, locale paths, and navigation switchers.
* 🎨 **[3. Frontend Landing Page](./frontend_landing.md)** — Editorial landing page sections (Hero, About, Achievements, Development, Gallery, Contact).
* 💬 **[4. Citizen Feedback Module](./feedback_system.md)** — Homepage featured carousels, detailed submission forms, photo uploads, and AJAX paginations.
* 🛡️ **[5. Secure Admin Backend](./admin_backend.md)** — Administrative layout rules, CMS controls, password profiles, and export systems.
* ⚙️ **[6. Database, Security & SEO](./database_security_seo.md)** — Schema configurations, security constraints, performance criteria, and SEO optimizations.
* 📞 **[7. Contacts Directory](./contacts.md)** — Admin-only institutional contact address book, CRUD operations, keyword search, and XLSX export.
* 🚨 **[8. Citizen Grievances Tracker](./complaints.md) (You are here)** — Admin-only complaint logging, category classification, resolution workflow, and XLSX export.
* 📅 **[9. Project Timeline Manager](./timelines.md)** — Standalone municipal project schedules, milestone checklists, progress tracking, and XLSX export.
* 👤 **[10. User Management & Roles](./user_management.md)** — Admin-only account provisioning, role-based access control gates, and lockout protections.

---

## 1. Overview & Purpose

The Citizen Grievances Tracker is an **admin-only internal register** for logging, categorizing, and resolving complaints received by Sachin Khandelwal's ward office through offline channels such as:
* **In-person ward office visits.**
* **Telephone or WhatsApp calls.**
* **Written letters or physical petitions.**

> This module is entirely distinct from the public Citizen Feedback system (Module 4). Whereas the feedback system collects star-rated public testimonials directly from citizens via the website, the Grievances Tracker is a backend intake tool used exclusively by administrators to log offline complaints. There is no public-facing component.

The module enables ward office staff to maintain a transparent and auditable record of every civic complaint received, its current resolution status, and the official action taken.

---

## 2. Admin Access & Authorization

* **Admin Panel Only:** The Grievances module is exclusively accessible from the admin panel at `/admin/complaints`. It is entirely absent from all public-facing routes.
* **View & Log:** All authenticated admin roles (`super_admin`, `moderator`, `editor`) may view the grievances list and log new complaints.
* **Log Resolution:** All authenticated admin roles may update the status and official action log of any complaint record.
* **Delete:** Permanently deleting a complaint record is restricted exclusively to the `super_admin` role to ensure audit integrity.

---

## 3. Grievance Record Structure

Each grievance entry stored in the `complaints` table must capture the following fields:

| Field | Type | Rules |
|---|---|---|
| `id` | Primary Key | Auto-increment. |
| `complainant_name` | `string` | Required. Full name of the citizen. |
| `complainant_mobile` | `string` | Required. Contact number for follow-up. |
| `area` | `string` | Required. Ward area or locality. |
| `category` | `enum` | Required. See category list below. |
| `description` | `text` | Required. Full complaint description logged by the admin. |
| `status` | `enum` | Required. Default `pending`. See status workflow below. |
| `official_action` | `text`, nullable | Admin's resolution log or action notes. |
| `attachment_path` | `string`, nullable | Path to an optional WebP-compressed evidence photo. |
| `created_at`, `updated_at` | Timestamps | Standard Laravel timestamps. |

### Category Values:
* `water` — Water Supply Issues
* `sanitation` — Drainage & Sanitation
* `road` — Road Damage & Potholes
* `electricity` — Power & Electricity
* `street_light` — Street Light Faults
* `other` — Other Grievances

### Status Workflow:

The grievance must follow a linear progression through these four states:

```text
Admin Logs Complaint
    │
    ▼
Status: 'pending'  (Initial state upon logging)
    │
    ▼
Status: 'under_review'  (Investigation or field visit underway)
    │
    ▼
Status: 'resolved'   ──► Official action logged in 'official_action' field
    OR
    └── 'rejected'   ──► Deemed out of scope or unactionable
```

Status is updated via the dedicated **Log Resolution** inline modal in the admin table, not via a separate page.

---

## 4. Listing View Requirements

The complaints index page at `admin/complaint/index.blade.php` must follow the established admin design language:

* **Page Header:** Standard `font-heading font-extrabold text-3xl` title "Citizen Grievances" with a descriptive subtitle. Two header-right action buttons: **Export XLSX** (ghost style) and **Log Grievance** (primary style).
* **Filter Bar:** A compact, inline filter form inside a `card-base` container with a keyword search input and a status dropdown filter (All / Pending / Under Review / Resolved / Rejected).
* **Records Table:** Standard `table table-md` layout inside a `card-base` container, with columns:
  * **Complainant** — Full name, mobile as `tel:` link, and status badge (`badge-warning`, `badge-info`, `badge-success`, `badge-error`).
  * **Area / Category** — Location in secondary color, category as `badge-outline badge-xs`.
  * **Description** — Truncated three-line preview (`line-clamp-3`), with logged date below.
  * **Official Action Log** — Truncated preview of the `official_action` text in a soft `bg-base-200/60` block, or an italic placeholder if not yet logged.
  * **Attachment** — A `56×56px` clickable thumbnail that opens the attachment in the same-page lightbox viewer (`dialog#viewer-modal`). Shows `—` if absent.
  * **Actions** — Log Resolution button (`btn-soft btn-info`) and Delete button (`btn-soft btn-error`, super_admin only).
* **Empty State:** Friendly italic prompt with an inline link to open the Log Grievance modal.
* **Pagination:** Standard Laravel `links()` component inside a `border-t` footer row.

---

## 5. Log Grievance Modal (Add)

The "Log Grievance" modal follows the standard `div.modal modal-bottom sm:modal-middle` pattern with `modal-open` class toggling.

### Form Fields:
* **Complainant Name** (required) + **Mobile Number** (required) — Two-column `sm:grid-cols-2` row using `<x-float-input />`.
* **Ward / Area** (required) + **Category** (required) — Two-column row; Category is a `floating-label` wrapped `<select>`.
* **Description** (required) — `floating-label` wrapped `<textarea>` (3 rows).
* **Attachment Photo** (optional) — `file-input file-input-primary file-input-sm` with a note that uploads auto-compress to WebP on the server side (max 5MB).
* **Form Footer:** `Cancel` (btn-ghost) and `Log Grievance` (btn-primary with floppy-disk icon).

### Image Upload Handling:
* The attachment is uploaded as part of a `multipart/form-data` POST request.
* Server-side WebP compression must be applied before storage, consistent with existing gallery and development works upload behaviour.
* Stored in `storage/app/public/complaints/`.

---

## 6. Log Resolution Modal (Edit / Update)

A secondary inline modal specifically for updating the status and action log of an existing grievance, accessible via the Edit (`btn-soft btn-info`) action button in the table row.

### Form Fields:
* **Grievance Status** (required) — `floating-label` wrapped `<select>` with all four status options.
* **Official Action Log** (optional) — `floating-label` wrapped `<textarea>` (4 rows) for detailed resolution notes.
* **Form Footer:** `Cancel` (btn-ghost) and `Save Resolution` (btn-primary).

### Modal State Behavior:
* `openResolveModal(complaint)` receives a JSON-encoded model instance and pre-populates `status` and `official_action` fields.
* The form action resolves to `PUT /admin/complaints/{id}`.

---

## 7. XLSX Export Requirements

* **Export Button:** Located in the page header alongside the "Log Grievance" button.
* **Export Modal:** A compact `modal-bottom sm:modal-middle` modal with a single **Status Filter** dropdown before downloading (All / Pending / Under Review / Resolved / Rejected).
* **Export Route:** `GET /admin/complaints/export` — triggers a streamed XLSX download response.
* **Export Format:** Styled Excel spreadsheet via `PhpOffice\PhpSpreadsheet`, consistent with the platform's `ExcelExportHelper` standards:
  * **Header Row:** Saffron background (`#FF8A3D`), bold white text, navy border (`#1E3A8A`).
  * **Data Rows:** White background, navy border, auto-width columns.
  * **Columns:** Complainant Name, Mobile, Area, Category, Description, Status, Official Action, Logged Date.
* **Filename:** `grievances_export_YYYY-MM-DD.xlsx` using the export date dynamically.

---

## 8. Database Schema

```sql
CREATE TABLE complaints (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    complainant_name    VARCHAR(191)    NOT NULL,
    complainant_mobile  VARCHAR(30)     NOT NULL,
    area                VARCHAR(191)    NOT NULL,
    category            ENUM('water','sanitation','road','electricity','street_light','other') NOT NULL,
    description         TEXT            NOT NULL,
    status              ENUM('pending','under_review','resolved','rejected') NOT NULL DEFAULT 'pending',
    official_action     TEXT            NULL,
    attachment_path     VARCHAR(500)    NULL,
    created_at          TIMESTAMP       NULL,
    updated_at          TIMESTAMP       NULL
);
```

---

## 9. Routing Map

| Method | URI | Controller Action | Gate / Role |
|---|---|---|---|
| `GET` | `/admin/complaints` | `ComplaintController@index` | `auth` |
| `POST` | `/admin/complaints` | `ComplaintController@store` | `auth` |
| `PUT` | `/admin/complaints/{complaint}` | `ComplaintController@update` | `auth` |
| `DELETE` | `/admin/complaints/{complaint}` | `ComplaintController@destroy` | `super-admin` |
| `GET` | `/admin/complaints/export` | `ComplaintController@export` | `auth` |
