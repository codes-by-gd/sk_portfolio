# Requirement Module 7: Contacts Directory

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
* 📞 **[7. Contacts Directory](./contacts.md) (You are here)** — Admin-only institutional contact address book, CRUD operations, keyword search, and XLSX export.
* 🚨 **[8. Citizen Grievances Tracker](./complaints.md)** — Admin-only complaint logging, category classification, resolution workflow, and XLSX export.
* 📅 **[9. Project Timeline Manager](./timelines.md)** — Standalone municipal project schedules, milestone checklists, progress tracking, and XLSX export.
* 👤 **[10. User Management & Roles](./user_management.md)** — Admin-only account provisioning, role-based access control gates, and lockout protections.

---

## 1. Overview & Purpose

The Contacts Directory is a **private, admin-only address book** for institutional and key civic contacts associated with Sachin Khandelwal's ward operations. It is not connected to the public-facing frontend and is entirely managed within the administrative backend panel.

The primary purpose of this module is to provide a structured, searchable digital rolodex for:
* **Municipal officials and ward office staff.**
* **Party workers and local BJP organizational contacts.**
* **Contractors, vendors, and service providers** engaged in development works.
* **Media personnel and liaison contacts** for public communications.

---

## 2. Admin Access & Authorization

* **Admin Panel Only:** The Contacts Directory is exclusively accessible from the admin panel at `/admin/contacts`. It is entirely absent from all public-facing routes.
* **View & Create:** All authenticated admin roles (`super_admin`, `moderator`, `editor`) may view contact listings and create new entries.
* **Edit:** All authenticated admin roles may edit existing contact records.
* **Delete:** Permanently deleting a contact record is restricted exclusively to the `super_admin` role. Other roles will not see a delete trigger in the action column.

---

## 3. Contact Record Structure

Each contact record stored in the `contacts` table must capture the following fields:

| Field | Type | Rules |
|---|---|---|
| `id` | Primary Key | Auto-increment. |
| `first_name` | `string` | Required. |
| `last_name` | `string`, nullable | Optional. |
| `mobile_number` | `string` | Required. Displayed as a tappable `tel:` link. |
| `email` | `string`, nullable | Optional. Validated as a valid email format. |
| `designation` | `string`, nullable | Role, title, or position (e.g. "Ward Officer", "Contractor"). |
| `address` | `text`, nullable | Postal or office address for correspondence. |
| `notes` | `text`, nullable | Internal administrative notes or special instructions. |
| `created_at`, `updated_at` | Timestamps | Standard Laravel timestamps. |

> **Note:** A computed `name` attribute on the model must concatenate `first_name` and `last_name` for display in table rows and the avatar initials fallback.

---

## 4. Listing View Requirements

The contacts index page at `admin/contacts/index.blade.php` must follow the established admin design language precisely:

* **Page Header:** Standard `font-heading font-extrabold text-3xl` title "Contacts Directory" with a descriptive subtitle, and two header-right action buttons: **Export XLSX** (ghost style) and **Add Contact** (primary style).
* **Filter Bar:** A compact, inline filter form inside a `card-base` container, providing a single keyword search input. The search must match across `first_name`, `last_name`, `mobile_number`, `designation`, and `email`.
* **Records Table:** Standard `table table-md` layout inside a `card-base` container, with columns:
  * **Contact** — Avatar initial block + full name.
  * **Mobile** — Tappable `tel:` anchor link with phone icon.
  * **Email** — Tappable `mailto:` link, shows `—` when absent.
  * **Designation** — Rendered as a `badge badge-outline badge-sm`.
  * **Address / Notes** — Truncated two-line preview (`line-clamp-2`).
  * **Actions** — Edit button (`btn-soft btn-info`) and Delete button (`btn-soft btn-error`, super_admin only).
* **Empty State:** Friendly italic prompt with an inline link to open the Add Contact modal.
* **Pagination:** Standard Laravel `links()` component inside a `border-t` footer row.

---

## 5. Add & Edit Contact Modal

Both the "Add" and "Edit" flows must use the same reusable modal pattern (`div.modal modal-bottom sm:modal-middle`) with JavaScript `modal-open` class toggling. A shared JavaScript function `openAddModal()` and `openEditModal(contact)` manage state.

### Form Fields (in Add/Edit modal):
* **First Name** (required) + **Last Name** — Two-column `sm:grid-cols-2` row using `<x-float-input />`.
* **Mobile Number** (required) + **Designation** — Two-column row using `<x-float-input />`.
* **Email Address** — Full-width using `<x-float-input type="email" />`.
* **Address** — `floating-label` wrapped `<textarea>` (2 rows).
* **Notes** — `floating-label` wrapped `<textarea>` (2 rows).
* **Form Footer:** `Cancel` (btn-ghost) and `Save Contact` (btn-primary with floppy-disk icon).

### Modal State Behavior:
* When **Add** is triggered, the modal title reads "Add Contact", the subtitle reads "Add a new institutional contact to the directory", form action points to `POST /admin/contacts`, and all inputs are cleared.
* When **Edit** is triggered (via `openEditModal(contact)` receiving a JSON-encoded model), the modal title reads "Edit Contact", the form action points to `PUT /admin/contacts/{id}` via a hidden `_method` input, and all inputs are pre-populated from the passed JSON data-attributes.

---

## 6. XLSX Export Requirements

* **Export Button:** Located in the page header alongside the "Add Contact" button.
* **Export Modal:** A compact `modal-bottom sm:modal-middle` modal with a single optional keyword filter input before downloading.
* **Export Route:** `GET /admin/contacts/export` — triggers a streamed XLSX download response.
* **Export Format:** Styled Excel spreadsheet via `PhpOffice\PhpSpreadsheet`, consistent with the platform's `ExcelExportHelper` standards:
  * **Header Row:** Saffron background (`#FF8A3D`), bold white text, navy border (`#1E3A8A`).
  * **Data Rows:** White background, navy border, auto-width columns.
  * **Columns:** Full Name, Mobile Number, Email, Designation, Address, Notes, Created Date.
* **Encoding:** All multi-script characters (Gujarati, Hindi names or notes) must render correctly with UTF-8 encoding enforced.
* **Filename:** `contacts_export_YYYY-MM-DD.xlsx` using the export date dynamically.

---

## 7. Database Schema

```sql
CREATE TABLE contacts (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    first_name      VARCHAR(191) NOT NULL,
    last_name       VARCHAR(191) NULL,
    mobile_number   VARCHAR(30)  NOT NULL,
    email           VARCHAR(191) NULL,
    designation     VARCHAR(191) NULL,
    address         TEXT         NULL,
    notes           TEXT         NULL,
    created_at      TIMESTAMP    NULL,
    updated_at      TIMESTAMP    NULL
);
```

---

## 8. Routing Map

| Method | URI | Controller Action | Gate / Role |
|---|---|---|---|
| `GET` | `/admin/contacts` | `ContactController@index` | `auth` |
| `POST` | `/admin/contacts` | `ContactController@store` | `auth` |
| `PUT` | `/admin/contacts/{contact}` | `ContactController@update` | `auth` |
| `DELETE` | `/admin/contacts/{contact}` | `ContactController@destroy` | `super-admin` |
| `GET` | `/admin/contacts/export` | `ContactController@export` | `auth` |
