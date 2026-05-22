# AGENT.md — Technical Specification & Development Guidelines

This document outlines the technical architecture, environment setup, database schema, and backend workflow requirements for Sachin Khandelwal's Official Public Website. AI coding agents must follow these guidelines strictly during implementation.

---

## 1. Project Overview & Identity
- **Owner:** Sachin Khandelwal (BJP Adhyaksh & Corporator, Vadodara Ward No. 7).
- **Core Goal:** A premium, multilingual public leadership website, civic engagement portal, and citizen feedback platform.
- **Architecture:** Single Page (SPA-style scrolling layout) for the public landing page, and a separate shareable page for detailed feedback submission. Includes an administrative backend panel.

---

## 2. Technical Stack & Environment

### Backend
- **Framework:** Laravel 13
- **Database:** MySQL
- **Tooling:** Vite for asset bundling

### Frontend Views
- **Templating:** Blade Templating for all view files (`.blade.php`).
- **Styling:** Tailwind CSS + daisyUI (compulsory UI components).

### Local Environment Setup
- **PHP Version:** Fixed to **PHP 8.4** in the project directory using `direnv`.
- **Configuration:** Maintain a `.envrc` file in the root containing environment declarations (e.g., forcing path resolution to PHP 8.4 binary).

---

## 3. Database Schema Planning

The database should consist of the following core tables with multilingual fields where appropriate.

### `users`
- Administrative users only. No public registration is allowed.
- Columns: `id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`.

### `feedbacks`
- Stores citizen reviews submitted via the shareable detailed feedback page.
- Columns:
  - `id` (primary key)
  - `name` (string)
  - `mobile_number` (string)
  - `area` (string)
  - `title` (string)
  - `message` (text)
  - `rating` (tinyInteger, 1 to 5 stars)
  - `status` (enum: `'pending'`, `'approved'`, `'rejected'`; default is `'pending'`)
  - `is_featured` (boolean, default `false`)
  - `avatar_path` (string, nullable; stored path to the optional user avatar uploaded/managed from the admin dashboard)
  - `created_at`, `updated_at`

### `feedback_images`
- Stores references to pictures uploaded with detailed feedback.
- Columns: `id`, `feedback_id` (foreign key to `feedbacks`), `image_path` (string), `created_at`, `updated_at`.

### `development_works`
- Stores details of Ward development projects.
- Columns:
  - `id` (primary key)
  - `title_en`, `title_gu`, `title_hi` (localized titles)
  - `description_en`, `description_gu`, `description_hi` (localized descriptions)
  - `location` (string)
  - `before_image` (string, nullable)
  - `after_image` (string, nullable)
  - `created_at`, `updated_at`

### `gallery_images`
- Stores media for the ward visits and event photo gallery.
- Columns:
  - `id` (primary key)
  - `image_path` (string)
  - `category` (string)
  - `caption_en`, `caption_gu`, `caption_hi` (localized captions)
  - `created_at`, `updated_at`

### `cms_pages` (or Dynamic Contents)
- Dynamic content management for section text.
- Columns: `id`, `key` (unique identifier, e.g. `'about_bio'`), `content_en`, `content_gu`, `content_hi` (text/mediumtext), `created_at`, `updated_at`.

### `settings`
- General settings and configurations.
- Columns: `id`, `key` (string, unique), `value` (text/json), `created_at`, `updated_at`.

---

## 4. Localization Strategy
The application must fully support three languages with the following configuration:
- **Primary Locale:** Gujarati (`gu`)
- **Secondary Locale:** Hindi (`hi`)
- **Third Locale:** English (`en`)

### Directory Structure
Localization files must be stored in:
- `resources/lang/en/`
- `resources/lang/gu/`
- `resources/lang/hi/`

### Middleware
Implement a custom middleware `SetLocale` to intercept requests, read selected locale (via session, cookie, or URL prefix), and configure Laravel's app locale dynamically:
```php
App::setLocale($locale);
```

---

## 5. Main Backend & Admin Panel Modules

The admin panel should be constructed using a unified Blade, Tailwind CSS, and daisyUI layout (dashboard styled with daisyUI components).

### A. Authentication Module
- **Registration:** Strictly prohibited. Accounts are created via Database Seeders only.
- **Features:** Standard login, password reset (via tokens), and "remember me" options.

### B. Feedback Management Module
- **Default Behavior:** Newly submitted feedbacks default to `pending` status.
- **Admin Capabilities:**
  - View all pending, approved, and rejected reviews.
  - Approve feedback.
  - Reject feedback.
  - Delete feedback.
  - Toggle "featured" status.
  - Upload or update an optional user avatar image (`avatar_path`) for any feedback record.
  - The admin dashboard feedback list must use AJAX-based pagination (updating the table asynchronously without full page reload).
- **Frontend Display Rules:**
  - **Homepage Carousel:** Displays ONLY approved feedbacks marked as featured (`status = 'approved'` AND `is_featured = true`). It must display multiple cards simultaneously on desktop (showing more feedbacks together) and render the user avatar image.
  - **Detailed Feedback Page:** Displays the detailed submission form at the top (primary priority) and lists ALL approved feedbacks (`status = 'approved'`) underneath (secondary priority). It must omit the user avatar images for simplicity/contrast, and pagination must be handled asynchronously via AJAX (no full page reload).
  - **Navbar CTA:** Homepage and layout navigation bars must feature a clear Call-to-Action button on the right linking to this detailed feedback page, and remove the scrolling 'Feedback' menu item.

### C. CMS Module
- Manage landing page contents (Hero copy, biography, leadership vision, achievements numbers, and contact office details).
- All editable text fields must provide tabs/inputs for translation in English, Gujarati, and Hindi.

### D. Gallery & Development Works Modules
- Create, update, and delete development work projects (with location, description, and before/after WebP photos).
- Upload and tag gallery images with categories and localized captions.

### E. Export Module
- Expose endpoints to download approved feedback datasets.
- Formats: CSV or Excel.
- Filters: Date range, Ward area, and star rating.

---

## 6. Security, Performance & SEO Guidelines

### Security
- **CSRF Protection:** Active on all forms (Laravel default).
- **XSS Sanitization:** Sanitize all citizen-submitted reviews before saving or rendering.
- **File Upload Validation:** Validate upload size, mime-types (`image/jpeg`, `image/png`, `image/webp`), and reject executable files.
- **Rate Limiting:** Throttle both the quick feedback submission route and the detailed feedback page submission route to prevent spam.

### Performance & Asset Optimization
- Use Vite to bundle styles and scripts.
- Enforce **WebP format conversion** for all uploaded development and feedback pictures.
- Utilize lazy loading (`loading="lazy"`) for all list/gallery images.
- Optimize queries to meet a target **Lighthouse score of 90+** on mobile and desktop.

### SEO
- Dynamically inject `hreflang` meta tags for multilingual search engines.
- Populate Open Graph (`og:image`, `og:title`, `og:description`) tags in Blade layout headers.
- Automatically generate and update a localized `sitemap.xml`.
