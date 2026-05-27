# Sachin Khandelwal — Official Public Website & Civic Portal

# Functional Requirements Suite (Requirement.md Index)

This index document coordinates and structures the functional requirements for Sachin Khandelwal's premium, multilingual personal brand and civic engagement website (BJP Ward 7, Vadodara). 

To ensure optimal structural legibility for both developers and AI coding agents, the requirement specifications have been divided into ten highly focused functional modules under the `requirements/` directory.

---

## 🗺️ Documentation Suite & AI Context Map

*To ensure strict architectural and design alignment, all AI coding agents must reference and adhere to the following unified project documentation suite:*

* 📄 **[README.md](./README.md)** — Standard repository overview, environment setup (PHP 8.4 via `direnv`), directory layouts, and agent onboarding workflows.
* 📋 **[Requirement.md](./Requirement.md) (You are here)** — Master index mapping functional specifications and modular requirements.
* ⚙️ **[AGENT.md](./AGENT.md)** — Technical development specifications, PHP 8.4 setup details, SQL database schemas, and backend routing/controllers.
* 🎨 **[DESIGN.md](./DESIGN.md)** — UX/UI Design system, semantic light/dark patriotic themes, daisyUI v5 layouts, fixed-height viewport rules, and official civic branding guidelines.
* 🛠️ **[DAISYUI.md](./DAISYUI.md)** — Comprehensive daisyUI 5 rules, class lists, and components reference (utilized as an LLM system-level skill).

---

## 📑 Functional Requirements Modules

All AI coding agents must consult these specific modular files when executing tasks across different domains of the portal:

### 📄 [Module 1: Project Overview & Identity](./requirements/overview.md)
* **Scope:** General website objectives, Sachin Khandelwal’s BJP Corporator branding guidelines, design inspiration (editorial biography layout vs loud campaign banners), local heritage integration (Laxmi Vilas Palace watermarks), and strict mobile-first viewport policies.

### 🌐 [Module 2: Localization & Language Strategy](./requirements/localization.md)
* **Scope:** Dynamic multilingual definitions across Gujarati (primary), Hindi (secondary), and English (tertiary), Laravel localization catalog structure (`resources/lang/`), dynamic database column selection for CMS, and native language switcher component rules.

### 🎨 [Module 3: Frontend Landing Page Layout](./requirements/frontend_landing.md)
* **Scope:** Architectural details of the single scrolling landing page sections: sticky navigation menu with active highlights, Hero greeting panels, Biography biography layouts, dynamic achievements statistics grid, Before/After development work sliders, localized ward galleries, and Contact cards.

### 💬 [Module 4: Citizen Feedback System](./requirements/feedback_system.md)
* **Scope:** Moderation state workflows (pending → approved/rejected), featured home carousel density, standalone shareable submission page rules (5-star golden rating components, optional device camera activation for mobile snaps, listing privacy controls), and AJAX-based dynamic pagination requirements.

### 🛡️ [Module 5: Secure Admin Backend](./requirements/admin_backend.md)
* **Scope:** Seeder-only administrative authorization bounds (no registration allowed), administrative drawer layout with lock-viewport dimensions (`100vh`), sidebar profile navigation triggers, AJAX pagination tables for moderation, translation-supported CMS forms, profile setting current-password checks, and CSV/Excel data exporters.

### ⚙️ [Module 6: Database, Security & SEO Infrastructure](./requirements/database_security_seo.md)
* **Scope:** Normalized MySQL schemas definitions (`users`, `feedbacks`, `cms_pages`, etc.), security constraints (CSRF, XSS filter, WebP image validations), IP rate limits, performance budget limits (Lighthouse 90+), eager loading configurations, dynamic multilingual Open Graph tags, and sitemaps.

### 📞 [Module 7: Contacts Directory](./requirements/contacts.md)
* **Scope:** Admin-only institutional contact address book for ward office staff, party workers, contractors, and media contacts. Covers CRUD operations via inline modals, keyword search, `super_admin`-restricted deletion, and styled XLSX export via `ExcelExportHelper`.

### 🚨 [Module 8: Citizen Grievances Tracker](./requirements/complaints.md)
* **Scope:** Admin-only offline complaint intake register for logging grievances received via visits, telephone, or letters. Covers category classification, a four-step resolution status workflow (`pending` → `under_review` → `resolved`/`rejected`), official action logging, optional WebP evidence photo upload, status-filtered XLSX export, and distinction from the public Feedback module.

### 📅 [Module 9: Project Timeline Manager](./requirements/timelines.md)
* **Scope:** Admin-only operational planning tool for standalone municipal projects. Covers project records (budget, schedule, phase, status), a child `milestones` table with a cascading foreign key, a computed `progress_percent` Eloquent accessor driving inline progress bars and radial-progress rings, milestone checklist management via a detail page, quick status-toggle forms, and status-filtered XLSX export.

### 👤 [Module 10: User Management & Roles](./requirements/user_management.md)
* **Scope:** `super_admin`-only account provisioning and access control. Covers three role definitions (`super_admin`, `moderator`, `editor`), a Gate-to-Route permission mapping table, self-modification lockout enforcement at both UI and controller layers, suspended account login rejection middleware, and `is_active` flag session invalidation.
