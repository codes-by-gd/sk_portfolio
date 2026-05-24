# Requirement Module 2: Localization & Language Strategy

*Part of the Sachin Khandelwal Portal Requirements Suite.*

---

## 🗺️ Requirements Suite Map

*To easily navigate between functional requirements modules, click any link below:*

* 📄 **[1. Project Overview](./overview.md)** — Core identity, design inspiration, branding guidelines, and mobile-first policies.
* 🌐 **[2. Localization & Language](./localization.md) (You are here)** — Multilingual configuration, locale paths, and navigation switchers.
* 🎨 **[3. Frontend Landing Page](./frontend_landing.md)** — Editorial landing page sections (Hero, About, Achievements, Development, Gallery, Contact).
* 💬 **[4. Citizen Feedback Module](./feedback_system.md)** — Homepage featured carousels, detailed submission forms, photo uploads, and AJAX paginations.
* 🛡️ **[5. Secure Admin Backend](./admin_backend.md)** — Administrative layout rules, CMS controls, password profiles, and export systems.
* ⚙️ **[6. Database, Security & SEO](./database_security_seo.md)** — Schema configurations, security constraints, performance criteria, and SEO optimizations.

---

## 1. Multilingual Support Scope

The portal must fully support three regional languages across the entire public-facing interface. All navigation bars, footers, form labels, errors, and system responses must translate seamlessly:

1. **ગુજરાતી (Gujarati) — Primary Locale**
   * Primary language for local ward public communications.
2. **हिन्दी (Hindi) — Secondary Locale**
   * Secondary community language.
3. **English (English) — Tertiary Locale**
   * Fallback for universal devices.

---

## 2. Localization Infrastructure

The backend must utilize standard **Laravel Localization** directory structure:
* `resources/lang/gu/` (Gujarati translation keys)
* `resources/lang/hi/` (Hindi translation keys)
* `resources/lang/en/` (English translation keys)

### Language Middleware
* Implement a `SetLocale` interceptor middleware.
* The middleware must fetch the developer/user preferred locale from cookie, session, or request parameters and configure Laravel dynamically:
  ```php
  App::setLocale($locale);
  ```

---

## 3. Dynamic CMS Localization Strategy

For CMS-managed dynamic database contents (such as Development Work details, biography pages, and photo captions), the database tables must hold separate fields for translation (e.g. `title_en`, `title_gu`, `title_hi`).
* The system will dynamically select the appropriate column during database querying based on the active session locale.

---

## 4. Language Switcher Dropdown

The public sticky navbar and mobile drawers must integrate an elegant, accessible language switcher component:
* Must display the native spelling of the languages:
  * **ગુજરાતી**
  * **हिन्दी**
  * **English**
* The selection must write back to the active session immediately, reloading the localized interface without layout breakage or routing loss.
