# Requirement Module 9: Project Timeline Manager

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
* 🚨 **[8. Citizen Grievances Tracker](./complaints.md)** — Admin-only complaint logging, category classification, resolution workflow, and XLSX export.
* 📅 **[9. Project Timeline Manager](./timelines.md) (You are here)** — Standalone municipal project schedules, milestone checklists, progress tracking, and XLSX export.
* 👤 **[10. User Management & Roles](./user_management.md)** — Admin-only account provisioning, role-based access control gates, and lockout protections.

---

## 1. Overview & Purpose

The Project Timeline Manager is an **admin-only planning and tracking tool** for monitoring the schedule, budget, and milestone completion of standalone municipal projects managed by Sachin Khandelwal's office.

> This module is **separate and distinct** from the Development Works module (Module 5-C). The Development Works module is a public-facing portfolio of before/after photo showcases for completed or ongoing ward projects. The Timeline Manager is a backend operational tool covering the step-by-step project lifecycle — budget, phases, scheduled dates, and individual milestone checklists — with no public-facing counterpart in the current phase.

Each project in this module represents a single civic undertaking (e.g. road resurfacing, drainage upgrade, streetlight installation), with its own dedicated milestone checklist that drives a live completion percentage visible in the admin table.

---

## 2. Admin Access & Authorization

* **Admin Panel Only:** The Timeline Manager is exclusively accessible from `/admin/timelines`. There are no public-facing routes.
* **View & Create:** All authenticated admin roles may view the timeline index and create new projects.
* **Edit & Milestone Management:** All authenticated admin roles may edit projects and add/update milestones.
* **Delete Projects & Milestones:** Permanently deleting a project (and its associated milestones via cascading foreign key) is restricted exclusively to the `super_admin` role.

---

## 3. Data Structure

### A. `timelines` Table — Project Records

Each project stored in the `timelines` table captures:

| Field | Type | Rules |
|---|---|---|
| `id` | Primary Key | Auto-increment. |
| `project_name` | `string` | Required. Short name of the municipal project. |
| `location` | `string` | Required. Ward area or street address. |
| `budget` | `decimal(12,2)`, nullable | Optional. Project budget in INR. |
| `start_date` | `date`, nullable | Optional. Planned or actual commencement date. |
| `target_completion` | `date`, nullable | Optional. Planned completion deadline. |
| `status` | `enum` | Required. See status values below. Default `pending`. |
| `current_phase` | `string` | Required. Short phase label (e.g. "Foundation Work"). |
| `notes` | `text`, nullable | Optional. Internal documentation or procurement notes. |
| `created_at`, `updated_at` | Timestamps | Standard Laravel timestamps. |

### Status Values:
* `pending` — Project is in the planning/tendering phase.
* `active` — Execution is actively underway.
* `completed` — All work is completed.
* `delayed` — Work is suspended or behind schedule.

### B. `milestones` Table — Project Steps

Each milestone is a child record linked to a parent `timelines` record:

| Field | Type | Rules |
|---|---|---|
| `id` | Primary Key | Auto-increment. |
| `timeline_id` | Foreign Key | `timelines.id`, cascades on delete. |
| `title` | `string` | Required. Step title (e.g. "Site Survey Complete"). |
| `description` | `text`, nullable | Optional. Additional memo or notes for the step. |
| `milestone_date` | `date`, nullable | Optional. Estimated or target date for this step. |
| `status` | `enum('pending','completed')` | Required. Default `pending`. |
| `created_at`, `updated_at` | Timestamps | Standard Laravel timestamps. |

### Computed Progress Percentage:

The `progress_percent` value must be computed dynamically on the `Timeline` Eloquent model as an accessor:

```php
public function getProgressPercentAttribute(): int
{
    $total     = $this->milestones->count();
    $completed = $this->milestones->where('status', 'completed')->count();

    return $total > 0 ? (int) round(($completed / $total) * 100) : 0;
}
```

This value is displayed as both a numeric percentage in the index table's progress bar and as a DaisyUI `radial-progress` ring in the project detail view.

---

## 4. Index Listing View

The timeline index at `admin/timeline/index.blade.php` must follow the established admin design language:

* **Page Header:** Standard `font-heading font-extrabold text-3xl` title "Project Timelines" with a descriptive subtitle. Two header-right action buttons: **Export XLSX** (ghost style) and **Create Project** (`<a>` tag linking to the create page, primary style).
* **Filter Bar:** Compact inline filter inside a `card-base` container: keyword search input + status dropdown.
* **Records Table:** Standard `table table-md` layout inside a `card-base` container with columns:
  * **Project** — Name (bold) + location (secondary color with location icon).
  * **Budget** — Formatted as `₹ X,XX,XXX.XX`, shows `—` if not set.
  * **Progress** — A thin horizontal progress bar (`bg-primary`) with milestone count and percentage label above it.
  * **Current Phase** — Rendered as a `badge badge-outline badge-sm`.
  * **Status** — `badge-ghost` (Planning), `badge-info` (Active), `badge-success` (Completed), `badge-error` (Delayed).
  * **Dates** — Start and Target End dates stacked vertically in small `text-[11px]` font.
  * **Actions** — Milestones button (`btn-soft btn-success` with `fa-list-check` icon), Edit button (`btn-soft btn-info`), Delete button (`btn-soft btn-error`, super_admin only).
* **Empty State:** Friendly italic prompt with a link to the create page.
* **Pagination:** Standard Laravel `links()` component.

---

## 5. Create & Edit Project Pages

Project creation and editing use **dedicated full pages** (not inline modals), following the same pattern as the Development Works module.

### Page Structure:
* **Back Navigation:** `btn btn-sm btn-ghost gap-1.5` link returning to the timeline index.
* **Page Title:** `font-heading font-extrabold text-2xl` — "Create Project Timeline" or "Edit Project Timeline".
* **Form Container:** Single `card-base rounded-2xl p-6 sm:p-8` card.
* **Validation Errors:** Standard `alert alert-error shadow-sm rounded-xl text-white` block with a bullet list.

### Form Sections:

**Section 1 — Project Identity:**
* Two-column `lg:grid-cols-2` grid: `project_name` + `location` via `<x-float-input />`.

**Section 2 — Schedule & Budget:**
* Four-column `lg:grid-cols-4` grid: `budget` (number), `start_date` (date), `target_completion` (date), and `status` (floating-label select).

**Section 3 — Phase & Notes:**
* `current_phase` via `<x-float-input />` (full width).
* `notes` via `floating-label` wrapped `<textarea>` (4 rows).

**Form Actions:** `Save Project` (`btn-primary` with floppy-disk icon) + `Cancel` (`btn-ghost border border-base-300` linking back to index).

---

## 6. Project Detail & Milestone Management View

The project detail page (`admin/timeline/show.blade.php`) serves as the milestone management screen and is the richest view in this module.

### Layout:
A two-column `lg:grid-cols-3` grid:
* **Left column (1/3 width):** Project Details card.
* **Right column (2/3 width):** Milestone list card.

### Left Card — Project Details:
* DaisyUI `radial-progress` ring displaying `progress_percent` value.
* Stacked key-value rows for: Status badge, Budget, Current Phase badge, Start Date, Target End.
* Internal Notes block in a `bg-base-200/60 border border-base-300` container.

### Right Card — Milestone Checklist:
* A vertical timeline layout using a `border-l-2 border-primary/20 ml-3 space-y-5` container.
* Each milestone renders as a positioned item with:
  * A filled circle marker (`bg-primary` if completed, `bg-base-300` if pending).
  * A `border border-base-300 hover:border-primary/30 p-4 rounded-2xl shadow-sm` inner card showing title, description, estimated date, and status badge (`badge-success` / `badge-ghost`).
  * **Quick Toggle:** A small inline form (`PUT` to `/admin/milestones/{id}`) to toggle status between `pending` and `completed` without opening a separate modal.
  * **Edit Step:** Opens the Edit Milestone modal (`btn-soft btn-info`).
  * **Delete Step:** Super_admin only (`btn-soft btn-error`).

### Add / Edit Milestone Modals:
Standard `div.modal modal-bottom sm:modal-middle` pattern. Both modals share the same form fields:
* **Title** (required) via `<x-float-input />`.
* **Description** (optional) via `floating-label` textarea.
* **Estimated Date** (optional) via `<x-float-input type="date" />`.
* **Status** (required) via `floating-label` select (Pending / Completed).

---

## 7. XLSX Export Requirements

* **Export Button:** Located in the page header.
* **Export Modal:** A compact modal with a single **Status Filter** dropdown.
* **Export Route:** `GET /admin/timelines/export` — triggers a streamed XLSX download response.
* **Export Scope:** Exports project-level data only (not individual milestone rows). Milestone count and progress percentage are computed columns in the spreadsheet.
* **Export Format:** Styled via `ExcelExportHelper`:
  * **Columns:** Project Name, Location, Budget (INR), Current Phase, Status, Start Date, Target Completion, Milestones (count), Progress (%), Notes.
* **Filename:** `timelines_export_YYYY-MM-DD.xlsx`.

---

## 8. Database Schema

```sql
CREATE TABLE timelines (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    project_name        VARCHAR(191)    NOT NULL,
    location            VARCHAR(191)    NOT NULL,
    budget              DECIMAL(12,2)   NULL,
    start_date          DATE            NULL,
    target_completion   DATE            NULL,
    status              ENUM('pending','active','completed','delayed') NOT NULL DEFAULT 'pending',
    current_phase       VARCHAR(191)    NOT NULL,
    notes               TEXT            NULL,
    created_at          TIMESTAMP       NULL,
    updated_at          TIMESTAMP       NULL
);

CREATE TABLE milestones (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    timeline_id     BIGINT UNSIGNED NOT NULL,
    title           VARCHAR(191)    NOT NULL,
    description     TEXT            NULL,
    milestone_date  DATE            NULL,
    status          ENUM('pending','completed') NOT NULL DEFAULT 'pending',
    created_at      TIMESTAMP       NULL,
    updated_at      TIMESTAMP       NULL,
    CONSTRAINT fk_milestones_timeline
        FOREIGN KEY (timeline_id) REFERENCES timelines(id) ON DELETE CASCADE
);
```

---

## 9. Routing Map

| Method | URI | Controller Action | Gate / Role |
|---|---|---|---|
| `GET` | `/admin/timelines` | `TimelineController@index` | `auth` |
| `GET` | `/admin/timelines/create` | `TimelineController@create` | `auth` |
| `POST` | `/admin/timelines` | `TimelineController@store` | `auth` |
| `GET` | `/admin/timelines/{timeline}` | `TimelineController@show` | `auth` |
| `GET` | `/admin/timelines/{timeline}/edit` | `TimelineController@edit` | `auth` |
| `PUT` | `/admin/timelines/{timeline}` | `TimelineController@update` | `auth` |
| `DELETE` | `/admin/timelines/{timeline}` | `TimelineController@destroy` | `super-admin` |
| `GET` | `/admin/timelines/export` | `TimelineController@export` | `auth` |
| `POST` | `/admin/milestones/{timeline}` | `MilestoneController@store` | `auth` |
| `PUT` | `/admin/milestones/{milestone}` | `MilestoneController@update` | `auth` |
| `DELETE` | `/admin/milestones/{milestone}` | `MilestoneController@destroy` | `super-admin` |
