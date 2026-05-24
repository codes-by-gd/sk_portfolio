# Requirement Module 6: Database, Security & SEO Infrastructure

*Part of the Sachin Khandelwal Portal Requirements Suite.*

---

## 🗺️ Requirements Suite Map

*To easily navigate between functional requirements modules, click any link below:*

* 📄 **[1. Project Overview](./overview.md)** — Core identity, design inspiration, branding guidelines, and mobile-first policies.
* 🌐 **[2. Localization & Language](./localization.md)** — Multilingual configuration, locale paths, and navigation switchers.
* 🎨 **[3. Frontend Landing Page](./frontend_landing.md)** — Editorial landing page sections (Hero, About, Achievements, Development, Gallery, Contact).
* 💬 **[4. Citizen Feedback Module](./feedback_system.md)** — Homepage featured carousels, detailed submission forms, photo uploads, and AJAX paginations.
* 🛡️ **[5. Secure Admin Backend](./admin_backend.md)** — Administrative layout rules, CMS controls, password profiles, and export systems.
* ⚙️ **[6. Database, Security & SEO](./database_security_seo.md) (You are here)** — Schema configurations, security constraints, performance criteria, and SEO optimizations.

---

## 1. Database Schema Specifications

The database must consist of the following normalized tables:

### A. `users` (Administrative Accounts)
* Columns: `id`, `first_name`, `last_name`, `email`, `password`, `avatar_path` (nullable), `remember_token`, `created_at`, `updated_at`.

### B. `feedbacks` (Citizen Reviews)
* Columns: `id`, `name`, `mobile_number`, `area`, `title`, `message`, `rating` (tinyInteger, 1-5), `status` (enum: `'pending'`, `'approved'`, `'rejected'`), `is_featured` (boolean), `avatar_path` (nullable), `created_at`, `updated_at`.

### C. `feedback_images` (Citizen Uploads)
* Columns: `id`, `feedback_id` (FK to feedbacks), `image_path`, `created_at`, `updated_at`.

### D. `development_works` (Municipal Showcase)
* Columns: `id`, `title_en`, `title_gu`, `title_hi`, `description_en`, `description_gu`, `description_hi`, `location`, `before_image` (nullable), `after_image` (nullable), `created_at`, `updated_at`.

### E. `gallery_images` (Ward Media)
* Columns: `id`, `image_path`, `category`, `caption_en`, `caption_gu`, `caption_hi`, `created_at`, `updated_at`.

### F. `cms_pages` (Dynamic Copywriting)
* Columns: `id`, `key` (unique slug, e.g. `'bio_text'`), `content_en`, `content_gu`, `content_hi`, `created_at`, `updated_at`.

---

## 2. Security Constraints & Protections

To protect the portal from malicious inputs and traffic surges, the application must deploy several security features:
1. **CSRF Protection:** Active across all state-mutating requests (standard Laravel form tokens).
2. **XSS Sanitization:** All citizen-submitted fields (Name, Title, Message, Area) must be sanitized and stripped of HTML script tags before storing or rendering on the frontend.
3. **Strict Upload Validations:** Citizens uploading photos must pass validation checks:
   * Mime-types restricted strictly to images (`image/jpeg`, `image/png`, `image/webp`).
   * Size limit capped to **2MB** per file.
4. **Rate Limiting (Spam Prevention):** Throttle public submission endpoints to restrict submission volume from the same IP address (e.g. limit to 3 reviews per hour).

---

## 3. Asset & Performance Optimization

To deliver a premium, highly responsive user experience, the application must conform to a strict performance budget targeting a **Lighthouse Score of 90+**:
* **WebP Asset Conversion:** All citizen-uploaded reviews photos and admin CMS uploads (portraits, before/after works, gallery items) must automatically compress and convert to the **WebP** format.
* **Lazy Loading:** Implement native `loading="lazy"` on all list-level and gallery-level image assets to reduce initial load sizes.
* **Eager Loading Database Relations:** To prevent N+1 query bottlenecks when loading paginated review lists, eager-load image attachments:
  ```php
  $feedbacks = Feedback::with('images')->where('status', 'approved')->paginate(10);
  ```
* **Production Optimizations:** Route caching, configuration compiling, and view pre-rendering must compile cleanly under Laravel command parameters.

---

## 4. Search Engine Optimization (SEO)

* **Multilingual Hreflang Tags:** Inject dynamic language alternative tags (`<link rel="alternate" hreflang="..." href="..." />`) to assist crawling engines.
* **Open Graph Layout Metadata:** blade templates must dynamically populate Open Graph properties (`og:title`, `og:description`, `og:image`) for seamless card rendering when share links are pasted on chat apps.
* **Automated Sitemaps:** Generate a `sitemap.xml` file mapping alternate routes dynamically.
