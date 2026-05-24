# Requirement Module 5: Secure Admin Backend

*Part of the Sachin Khandelwal Portal Requirements Suite.*

---

## 🗺️ Requirements Suite Map

*To easily navigate between functional requirements modules, click any link below:*

* 📄 **[1. Project Overview](./overview.md)** — Core identity, design inspiration, branding guidelines, and mobile-first policies.
* 🌐 **[2. Localization & Language](./localization.md)** — Multilingual configuration, locale paths, and navigation switchers.
* 🎨 **[3. Frontend Landing Page](./frontend_landing.md)** — Editorial landing page sections (Hero, About, Achievements, Development, Gallery, Contact).
* 💬 **[4. Citizen Feedback Module](./feedback_system.md)** — Homepage featured carousels, detailed submission forms, photo uploads, and AJAX paginations.
* 🛡️ **[5. Secure Admin Backend](./admin_backend.md) (You are here)** — Administrative layout rules, CMS controls, password profiles, and export systems.
* ⚙️ **[6. Database, Security & SEO](./database_security_seo.md)** — Schema configurations, security constraints, performance criteria, and SEO optimizations.

---

## 1. Authentication Restrictions

* **No Public Registration:** Standard public registration endpoints must be completely disabled.
* **Seeder-Only Accounts:** Administrative accounts are established solely via database migrations and database seeders.
* **Core Features:** Standard secure login, secure session configurations, password resets, and "Remember Me" cookies.

---

## 2. Admin Layout & Viewport Scroll Isolation

To provide a premium admin experience, the backend panel must utilize a locked viewport shell:
* **Fixed Viewport Shell (`100vh`):** The main HTML page container must set `overflow: hidden`. The page header, top saffron ribbon, and left navigation sidebar remain locked in place.
* **Scroll-Isolated Content Area:** Only the central main content area (`<main>`) must feature `overflow-y: auto`, serving as the only scrollable region of the screen.
* **Sidebar Profile Block:** The "Logged In As" section in the left sidebar must serve as an interactive navigation link pointing to the Admin Profile settings:
  * Renders a circular user avatar image (or initials fallback).
  * Hovering triggers a smooth saffron background highlight and displays a saffron edit pen icon.
  * Active highlights (`bg-primary`) apply when the active route is `/admin/profile`.

---

## 3. Core Admin Backend Modules

### A. Feedback Management Module (Asynchronous)
* **View Template:** The core feedback management dashboard must be located at `resources/views/admin/feedback.blade.php` (renamed from `dashboard.blade.php`).
* Displays a list of all incoming citizen reviews.
* **AJAX Pagination:** The list must paginated asynchronously via AJAX. Changing pages must load contents into the review table dynamically without page reloads.
* **Predictable Action Button Sequence:**
  To maintain a consistent visual grid that prevents layout shifts across different moderation states, action buttons in the feedback list table must follow a strict left-to-right order:
  1. **Approve** (success, shown if status is not approved)
  2. **Reject** (error, shown if status is not rejected)
  3. **Feature** (warning, shown only if status is approved)
  4. **Edit Details** (info, always shown, pinned side-by-side on the right)
  5. **Delete Permanently** (error, always shown, pinned on the far-right edge)
* **Interactive Star Rating Input:**
  The rating field in the Edit Feedback modal must use the **DaisyUI Star Rating** mask stars (`rating rating-md gap-0.5`). To unify input alignment, the star container must be enclosed inside a structured input border with a half-overlapping floating outline label matching `x-float-input` elements.
* **Submitted Attachments Grid & Same-Page Lightbox Viewer:**
  * **Table Preview Click:** Clicking image previews inside the feedback list table must open a high-resolution version inside a premium, native HTML5 same-page Lightbox Dialog (`<dialog id="viewer-modal">`) featuring an overlay blur and quick close triggers, rather than opening external browser tabs.
  * **Edit Modal Attachment Panel:** The Edit Feedback modal must feature a dedicated "Submitted Attachments" thumbnail grid below the text input fields. Zoom icons appear on hover, and clicking any thumbnail opens it instantly in the same-page Lightbox Dialog.
* **Administrative Controls:**
  * Approve a review (changing status to `approved`).
  * Reject a review (changing status to `rejected`).
  * Feature/Unfeature a review (toggling the `is_featured` boolean).
  * Upload or edit an optional custom User Avatar image to represent the citizen.
  * Delete a review.

### B. Dynamic CMS Module
* Allows the administrator to modify text contents on the public scrolling landing page:
  * Hero greetings, designation subtitles, mission statement.
  * About biography copy and photo uploads.
  * Achievements stats counts.
  * Contact addresses, social links, and working hours.
* **Translation Support:** All text inputs in this module must provide side-by-side inputs (or tabs) for Gujarati, Hindi, and English translations.

### C. Development Works & Gallery Management
* Create, edit, and delete Development Work items (titles, categories, descriptions, locations, and Before/After WebP photo uploads).
* Add and categorize Gallery photos with localized caption fields.

### D. Approved Feedback Exports Module
* Expose endpoints allowing administrators to download approved citizen feedback databases.
* **Export Formats:** CSV or Excel.
* **Filters:** Date range, rating stars count, and citizen ward area.

### E. Secure Profile & Password Management
* Allows administrators to update their personal details: First Name, Last Name, and Email (email must remain unique in the `users` table).
* Allows uploading a custom profile picture/avatar.
* **Secure Password Reset:** Changing the password requires entering the active `current_password` matching the database hash, alongside a new password confirmation.
