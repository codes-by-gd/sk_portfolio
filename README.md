# Sachin Khandelwal — Official Public Website & Civic Leadership Portal

A premium, highly optimized, multilingual civic engagement platform and feedback portal built for **Sachin Khandelwal** (BJP Adhyaksh & Corporator, Vadodara Ward No. 7). 

This portal is designed to build public trust, bridge the gap between citizens and their representative, and showcase local ward development works.

---

## 🗺️ Documentation Suite & AI Context Map

*To ensure strict architectural and design alignment, all AI coding agents must reference and adhere to the following unified project documentation suite:*

* 📄 **[README.md](./README.md) (You are here)** — Standard repository overview, environment setup (PHP 8.4 via `direnv`), directory layouts, and agent onboarding workflows.
* 📋 **[Requirement.md](./Requirement.md)** — Master index mapping functional specifications and modular requirements.
* ⚙️ **[AGENT.md](./AGENT.md)** — Technical development specifications, PHP 8.4 setup details, SQL database schemas, and backend routing/controllers.
* 🎨 **[DESIGN.md](./DESIGN.md)** — UX/UI Design system, semantic light/dark patriotic themes, daisyUI v5 layouts, fixed-height viewport rules, and official civic branding guidelines.
* 🛠️ **[DAISYUI.md](./DAISYUI.md)** — Comprehensive daisyUI 5 rules, class lists, and components reference (utilized as an LLM system-level skill).

---

## 🚀 Technical Stack

* **Backend Framework:** Laravel 13
* **Database:** MySQL
* **Frontend Engines:** Blade Templating + Vite + Alpine.js
* **Styling Framework:** Tailwind CSS v4 + daisyUI v5 (compulsory UI components)
* **PHP Runtime:** PHP 8.4 (enforced locally via `direnv` / `.envrc`)

---

## 📂 Directory Layout

The project follows a standard Laravel directory structure. Key directories related to civic components:

```text
├── app/
│   ├── Http/
│   │   ├── Controllers/   # Backend admin dashboard controllers
│   │   └── Middleware/    # Includes SetLocale middleware for translations
│   └── Models/            # Database Models (User, Feedback, DevelopmentWork, etc.)
├── config/                # Framework settings & configurations
├── database/
│   ├── migrations/        # MySQL table structures (Feedbacks, cms_pages, settings)
│   └── seeders/           # Includes Admin users database seeders
├── requirements/          # Modular functional requirement files (1 to 6)
│   ├── overview.md        # Brand identity, SPA overview, mobile-first policies
│   ├── localization.md    # Multi-language configuration & middleware
│   ├── frontend_landing.md# Single scrolling landing page components detail
│   ├── feedback_system.md # Citizen carousels, detailed forms, photo captures
│   ├── admin_backend.md   # Viewport locks, moderation drawer, dynamic CMS
│   └── database_security_seo.md # Schemas, WebP performance, XSS/CSRF security
├── resources/
│   ├── css/
│   │   └── app.css        # Tailwind 4 directives and custom card-base overrides
│   ├── lang/              # Multilingual translations (en/, gu/, hi/)
│   └── views/
│       ├── layouts/       # Decoupled templates (app.blade.php vs admin.blade.php)
│       ├── components/    # Reusable custom blade inputs (e.g. float-input)
│       └── admin/         # Locked-viewport backend dashboard layout views
├── routes/
│   └── web.php            # Frontend, feedback submit, and secure admin routes
├── vite.config.js         # Asset compiler utilizing the Vite 8 compiler
└── .envrc                 # direnv config targeting local PHP 8.4 path resolution
```

---

## ⚙️ Environment Setup (PHP 8.4 via `direnv`)

This project strictly enforces **PHP 8.4** for execution. To ensure consistency between developer machines, CI pipelines, and AI coding agents, we utilize `direnv` to automatically override path resolution inside the project workspace directory.

### How it Works
1. **The `.envrc` File:** Pinned in the workspace root, this configuration registers the local `.bin` folder at the front of your shell's `PATH`:
   ```bash
   export PATH="/var/www/html/Learning/Review/.bin:$PATH"
   ```
2. **The `.bin/php` Symlink:** Inside the `.bin/` folder, a symbolic link `php` points directly to `/usr/bin/php8.4` on the host system.
3. **Execution Lock:** When you run `php artisan`, `composer`, or `phpunit` from the workspace root, your shell automatically resolves `php` to `/usr/bin/php8.4` via `.bin/php`. This completely avoids version mismatches with other global PHP runtimes.

### Prerequisites & Host Installation

If you don't have `direnv` configured on your system, follow these quick steps:

#### Step A: Install the `direnv` package
* **Ubuntu/Debian:** `sudo apt install direnv`
* **Fedora/RHEL:** `sudo dnf install direnv`
* **macOS (via Homebrew):** `brew install direnv`

#### Step B: Hook `direnv` into your default shell
Add the appropriate activation hook to your shell's initialization file:
* **For Bash (`~/.bashrc`):**
  ```bash
  eval "$(direnv hook bash)"
  ```
* **For Zsh (`~/.zshrc`):**
  ```bash
  eval "$(direnv hook zsh)"
  ```
* **For Fish (`~/.config/fish/config.fish`):**
  ```fish
  direnv hook fish | source
  ```
*Reload your terminal after editing the shell config file!*

---

## 🛠️ Quick Local Setup

Follow these steps to spin up the local development environment:

### 1. Enable Environment Paths
Once `direnv` is installed, allow it to authorize workspace path configurations:
```bash
direnv allow
# Check that the runtime successfully locks to PHP 8.4:
php -v  # Expected output: PHP 8.4.x
```

### 2. Install Project Dependencies
Run both Composer and NPM package installers to gather dependencies:
```bash
composer install
npm install
```

### 3. Environment Configuration
Duplicate the configuration file and configure your database and system parameters:
```bash
cp .env.example .env
php artisan key:generate
```
*Make sure to configure your `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD` variables inside `.env` to target your local MySQL database instance.*

### 4. Database Setup & Seeders
Create the database tables and populate the default administrative user accounts (Note: Public registration is disabled; logins exist only via database seeds):
```bash
php artisan migrate --seed
```

### 5. Compiling Assets & Local Dev Server
Launch Vite to hot-reload styles and run the backend server:
```bash
# Terminal 1: Compile asset pipeline
npm run dev

# Terminal 2: Run Laravel server
php artisan serve
```

---

## 🤖 AI Agent Workflow & Instructions

When executing tasks or proposing adjustments to this codebase, all AI coding agents must respect these guidelines:
1. **Never write raw custom CSS** when a Tailwind utility class or DaisyUI v5 component is available. Refer to [DAISYUI.md](./DAISYUI.md) for approved class naming conventions.
2. **Never bypass localization.** All texts, buttons, and system responses must use `__('keys')` routing mapped under the Gujarati, Hindi, and English dictionaries in `resources/lang/`.
3. **Respect Layout Separation.** The public homepage must use the `layouts/app.blade.php` framework, and the admin panel must lock strictly into `layouts/admin.blade.php` keeping stylesheet variables isolated.
4. **Maintain Database Integrity.** Changes to models or columns must be done via standard migration scripts under `database/migrations/` and documented under [AGENT.md](./AGENT.md).
