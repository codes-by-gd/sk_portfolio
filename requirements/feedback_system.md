# Requirement Module 4: Citizen Feedback System

*Part of the Sachin Khandelwal Portal Requirements Suite.*

---

## 🗺️ Requirements Suite Map

*To easily navigate between functional requirements modules, click any link below:*

* 📄 **[1. Project Overview](./overview.md)** — Core identity, design inspiration, branding guidelines, and mobile-first policies.
* 🌐 **[2. Localization & Language](./localization.md)** — Multilingual configuration, locale paths, and navigation switchers.
* 🎨 **[3. Frontend Landing Page](./frontend_landing.md)** — Editorial landing page sections (Hero, About, Achievements, Development, Gallery, Contact).
* 💬 **[4. Citizen Feedback Module](./feedback_system.md) (You are here)** — Homepage featured carousels, detailed submission forms, and AJAX paginations.
* 🛡️ **[5. Secure Admin Backend](./admin_backend.md)** — Administrative layout rules, CMS controls, password profiles, and export systems.
* ⚙️ **[6. Database, Security & SEO](./database_security_seo.md)** — Schema configurations, security constraints, performance criteria, and SEO optimizations.

---

## 1. Overview & Workflows

To prevent spam, reviews submitted by citizens must follow a strict moderation state-machine:

```text
Citizen Submits Review (Form)
    │
    ▼
Status set to 'pending' (Hidden from public)
    │
    ▼
Admin Panel Moderation Decision:
   ├── Approve ──► Status set to 'approved' (Visible in public lists)
   │                  ├── Mark as 'is_featured' ──► Displays on Homepage Carousel
   │                  └── Leave standard ──────────► Displays on Detailed page list
   └── Reject ───► Status set to 'rejected' (Omitted entirely)
```

---

## 2. Public Homepage Feedback Carousel

* Displays approved citizen reviews marked as featured (`status = 'approved'` AND `is_featured = true`).
* **Listing Density:** The carousel must display multiple reviews simultaneously on desktop/large screens (e.g. 3 cards per slide) to allow visitors to scan multiple reviews at once.
* **Fields Shown:** Citizen Name, Ward Area, Rating (1 to 5 gold stars), and Review Message.
* **No Quick Form:** An inline quick feedback form is completely removed from the landing page to keep it clean.

---

## 3. Standalone Shareable Detailed Feedback Page

This is a dedicated, standalone page optimized for easy sharing on chat platforms (e.g. WhatsApp / SMS) to collect citizen reviews. It features two prioritised sections:

### A. Detailed Submission Form (Primary Top Focus)
Positioned at the top of the page for immediate accessibility.
* **Input Fields:**
  * Full Name (required)
  * Mobile Number (required, for validation)
  * Area/Ward (required)
  * Feedback Message (required)
  * 1-to-5 Star Interactive Selector (required, styled with golden star masks)

### B. Approved Feedbacks Listing (Secondary Bottom Focus)
* Positioned below the submission form.
* Displays a list of all approved reviews (`status = 'approved'`).
* **Privacy Controls & Initials Avatar Rendering:** To protect citizen privacy, mobile numbers must be omitted in this public list. It renders a clean CSS circle containing the citizen's initials. It displays the citizen's name, area, rating stars, and review message.

---

## 4. AJAX-Based Pagination Requirement

* **Smooth User Experience:** The listing of approved feedbacks beneath the detailed submission form must handle pagination asynchronously via AJAX.
* **No Full Page Reload:** Clicking pagination page links must update the feedback list container dynamically without reloading the browser window or shifting the user's focus away from the form.
