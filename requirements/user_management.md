# Requirement Module 10: User Management & Roles

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
* 📅 **[9. Project Timeline Manager](./timelines.md)** — Standalone municipal project schedules, milestone checklists, progress tracking, and XLSX export.
* 👤 **[10. User Management & Roles](./user_management.md) (You are here)** — Admin-only account provisioning, role-based access control gates, and lockout protections.

---

## 1. Overview & Purpose

The User Management module provides the **Super Admin** with a centralized interface to provision, configure, and deactivate internal admin user accounts. It enforces a structured role-based permission hierarchy that governs which sections of the admin panel each user can access and which operations they may perform.

> **No public registration is permitted under any circumstances.** The application must have all standard registration routes and controllers completely disabled. New administrator accounts can only be created from within this module by an authenticated `super_admin`. This requirement extends and supersedes the general restriction described in [Module 5 — Secure Admin Backend](./admin_backend.md).

---

## 2. Role Definitions

The platform supports three distinct admin roles, stored as a `role` column in the `users` table:

### `super_admin` — Full System Access
The highest privilege tier. All admin panel sections are fully accessible with no restrictions.

| Capability | Access |
|---|---|
| View all admin modules | ✅ |
| Create, edit admin accounts | ✅ |
| Delete any record across all modules | ✅ |
| Deactivate / suspend admin accounts | ✅ |
| Manage own profile | ✅ |

### `moderator` — Citizen-Facing Operations
Focused on moderating citizen-submitted content and managing civic engagement data.

| Capability | Access |
|---|---|
| View & moderate Feedback (approve, reject, feature) | ✅ |
| Log & resolve Citizen Grievances | ✅ |
| View Contacts Directory | ✅ |
| View Timeline Manager | ✅ |
| Delete any record | ❌ |
| Create or manage admin accounts | ❌ |

### `editor` — Content & Media Management
Focused on controlling publicly visible content on the ward website.

| Capability | Access |
|---|---|
| Manage CMS page content | ✅ |
| Manage Development Works (CRUD) | ✅ |
| Manage Gallery Images (CRUD) | ✅ |
| View Feedback list | ✅ |
| Approve, reject, or feature Feedback | ❌ |
| Delete any record | ❌ |
| Create or manage admin accounts | ❌ |

---

## 3. Gate-to-Route Mapping

Roles are enforced through Laravel Gates and middleware defined in the `AppServiceProvider`. The mapping between gates and routes must be precisely defined as follows:

| Gate Name | Authorized Roles | Protected Routes / Actions |
|---|---|---|
| `super-admin` | `super_admin` | Delete actions across all modules, user provisioning, account deactivation. |
| `moderator` | `super_admin`, `moderator` | Feedback approve/reject/feature, grievance resolution logging. |
| `editor` | `super_admin`, `editor` | CMS page editing, development works CRUD, gallery CRUD. |

---

## 4. Admin Access & Authorization

* **Super Admin Only:** The `/admin/users` route and all user management endpoints are protected by the `super-admin` gate. Other roles are completely blocked from viewing or accessing this module.
* **Self-Modification Lockout:** An authenticated super_admin must not be able to delete their own account or demote/deactivate themselves through the UI. This is enforced both at the view layer (buttons disabled or hidden for self) and at the controller layer (validation check using `auth()->id() !== $user->id`).

---

## 5. User Record Structure

The `users` table must be extended from the base Laravel schema to include:

| Field | Type | Rules |
|---|---|---|
| `id` | Primary Key | Auto-increment. |
| `first_name` | `string` | Required. |
| `last_name` | `string` | Required. |
| `email` | `string`, unique | Required. Used for login. |
| `password` | `string` (bcrypt) | Required. Minimum 8 characters. |
| `role` | `enum` | Required. `super_admin`, `moderator`, or `editor`. |
| `is_active` | `boolean` | Default `true`. Suspended accounts cannot log in. |
| `avatar_path` | `string`, nullable | Optional profile avatar, managed via Profile Settings module. |
| `remember_token` | `string`, nullable | Standard Laravel remember-me token. |
| `created_at`, `updated_at` | Timestamps | Standard Laravel timestamps. |

> A computed `name` attribute on the User model must concatenate `first_name` and `last_name` for display in table rows, the sidebar profile block, and the avatar initials fallback.

---

## 6. Listing View Requirements

The user management index at `admin/user/index.blade.php` must follow the established admin design language:

* **Page Header:** Standard `font-heading font-extrabold text-3xl` title "User Management" with a descriptive subtitle. A single header-right action button: **Add Administrator** (primary style).
* **Records Table:** Standard `table table-md` layout inside a `card-base` container with columns:
  * **Administrator** — `9×9` avatar block (avatar image or initials fallback in `bg-primary/10 text-primary`) + name (bold). An `Active Session` badge (`badge-primary badge-xs`) appears alongside the name of the currently authenticated user.
  * **Email** — Plain text in `text-xs font-semibold`.
  * **Role** — Semantic DaisyUI badge: `badge-error` (Super Admin), `badge-info` (Moderator), `badge-success` (Editor), each with an appropriate icon prefix.
  * **Status** — `badge-success badge-outline` (Active) or `badge-ghost opacity-60` (Suspended).
  * **Registered** — `created_at` formatted as `M d, Y`.
  * **Actions** — Edit button (`btn-soft btn-info`); Delete button (`btn-soft btn-error`). Delete is disabled (opacity-30, cursor-not-allowed) for the currently authenticated user row.
* **Pagination:** Standard Laravel `links()` component.

---

## 7. Add Administrator Modal

The "Add Administrator" modal follows the standard `div.modal modal-bottom sm:modal-middle` pattern with `modal-open` class toggling.

### Form Fields:
* **First Name** + **Last Name** — Two-column `sm:grid-cols-2` row using `<x-float-input />`.
* **Email Address** (required) — Full-width `<x-float-input type="email" />`.
* **Password** + **Confirm Password** — Two-column row using `<x-float-input type="password" />`.
* **Access Role** (required) — `floating-label` wrapped `<select>` with options for Moderator (default), Editor, and Super Admin.
* **Form Footer:** `Cancel` (btn-ghost) and `Register Admin` (btn-primary with floppy-disk icon).

### Password Policy:
* Minimum 8 characters.
* Must match the confirmation field (Laravel `confirmed` rule).
* Passwords are hashed via Laravel's `bcrypt` / `Hash::make()` before storage.

---

## 8. Edit Administrator Modal

A shared edit modal (`openEditUserModal(user)`) receives a JSON-encoded user model and pre-populates inputs.

### Editable Fields:
* **First Name** + **Last Name** — Two-column row.
* **Email Address** — Full-width.
* **Access Role** + **Account Status** — Two-column row via `floating-label` selects.

### Self-Modification Lockout (UI Enforcement):
When `user.id` equals the currently authenticated user's ID, the `role` and `is_active` select elements must be set to `disabled = true` to prevent accidental self-demotion or self-suspension through the modal form.

> The controller must additionally enforce this restriction server-side, ignoring `role` and `is_active` field updates when the target record belongs to the authenticated session user.

---

## 9. Authentication Middleware & Suspended Account Handling

* **Login Guard:** The `AuthenticatedSessionController` (or equivalent login handler) must check the `is_active` flag on a successful credential match. If `is_active = false`, the login attempt must be rejected with a validation error:
  > "Your account has been suspended. Please contact the Super Administrator."
* **Session Invalidation:** If a currently logged-in user's `is_active` flag is set to `false` while their session is live, the next request must redirect them to the login page.

---

## 10. Database Schema

```sql
-- Extended users table (additions to base Laravel schema)
ALTER TABLE users
    ADD COLUMN first_name  VARCHAR(191)                                   NOT NULL AFTER id,
    ADD COLUMN last_name   VARCHAR(191)                                   NOT NULL AFTER first_name,
    ADD COLUMN role        ENUM('super_admin','moderator','editor')        NOT NULL DEFAULT 'editor' AFTER password,
    ADD COLUMN is_active   TINYINT(1)                                     NOT NULL DEFAULT 1 AFTER role,
    ADD COLUMN avatar_path VARCHAR(500)                                   NULL AFTER is_active;
```

---

## 11. Routing Map

| Method | URI | Controller Action | Gate / Role |
|---|---|---|---|
| `GET` | `/admin/users` | `UserController@index` | `super-admin` |
| `POST` | `/admin/users` | `UserController@store` | `super-admin` |
| `PUT` | `/admin/users/{user}` | `UserController@update` | `super-admin` |
| `DELETE` | `/admin/users/{user}` | `UserController@destroy` | `super-admin` |
