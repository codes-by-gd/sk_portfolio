# Requirement Module 3: Frontend Landing Page Layout

*Part of the Sachin Khandelwal Portal Requirements Suite.*

---

## 🗺️ Requirements Suite Map

*To easily navigate between functional requirements modules, click any link below:*

* 📄 **[1. Project Overview](./overview.md)** — Core identity, design inspiration, branding guidelines, and mobile-first policies.
* 🌐 **[2. Localization & Language](./localization.md)** — Multilingual configuration, locale paths, and navigation switchers.
* 🎨 **[3. Frontend Landing Page](./frontend_landing.md) (You are here)** — Editorial landing page sections (Hero, About, Achievements, Development, Gallery, Contact).
* 💬 **[4. Citizen Feedback Module](./feedback_system.md)** — Homepage featured carousels, detailed submission forms, photo uploads, and AJAX paginations.
* 🛡️ **[5. Secure Admin Backend](./admin_backend.md)** — Administrative layout rules, CMS controls, password profiles, and export systems.
* ⚙️ **[6. Database, Security & SEO](./database_security_seo.md)** — Schema configurations, security constraints, performance criteria, and SEO optimizations.

---

## 1. Sticky Navigation Bar (Navbar)

* Sticky pinned at the top of the browser window as the user scrolls.
* **Logo Block:** Name and designation badge on the left ("Sachin Khandelwal / BJP Adhyaksh · Ward 7").
* **Section Links:** Home, About, Development Work, Achievements, Gallery, Contact. Clicking a link smoothly scrolls the page to the target anchor.
* **Active Highlights:** Highlights the navigation link corresponding to the section currently visible in the browser viewport.
* **Right Align CTA:** A prominent "Give Feedback" button positioned on the far right, directing users to the standalone detailed feedback submission page.
* **Language Switcher:** A native dropdown selector integrated alongside the CTA.

---

## 2. Hero Section

* **Layout:** Two-column grid (desktop/large viewports) degrading to a centered vertical stack on mobile devices.
* **Left Column:**
  * Saffron greeting card ("Namaste & Welcome").
  * Bold heading: Sachin Khandelwal.
  * Outlined BJP Designation pill: "BJP Adhyaksh & Corporator · Vadodara Ward No. 7".
  * Editorial mission statement outlining commitment to municipal excellence.
  * **CTA Buttons:** Primary saffron button ("Share Your Feedback" links to the detailed feedback page) and a soft secondary button ("View Development Work" scrolls down).
* **Right Column:**
  * High-resolution, professional portrait image.
  * Overlaid with animated floating civic highlight tags (e.g. *Road Development*, *Cleanliness*, *Water Supply*, *Healthcare*, etc.).
* **Aesthetic Touches:** Saffron radial background glow and a subtle palace outline silhouette watermark representing Vadodara’s heritage.

---

## 3. Biography / About Section

* Beautiful, narrative-driven grid showing Sachin Khandelwal's civic journey, party responsibilities, and leadership vision.
* Styled like a modern editorial layout with text columns flanked by high-quality action photos.

---

## 4. Development Work Section

* Shows municipal infrastructure projects completed in Ward 7.
* **Card Grid:** Displays cards with Project Title, Category tags, and Location tags.
* **Interactive Diff Sliders:** Where applicable, use image comparison sliders showing side-by-side **Before** and **After** views of road, sewer, or park restoration works.
* Admin controls must feed these projects dynamically via backend CMS.

---

## 5. Achievements Section

* High-impact statistics grid showcasing civic indicators:
  * Completed Works count.
  * Public Engagements count.
  * Welfare Campaigns conducted.
* Styled as a cohesive, modern DaisyUI stats grid.

---

## 6. Ward Event Photo Gallery

* A responsive grid exhibiting photos from community programs, local ward inspections, and public interaction sessions.
* Features quick category filters (e.g. *Events*, *Inspections*, *Welfare*) and localized image captions on click/hover.

---

## 7. Contact & Office Locations

* Clear, user-friendly details of Sachin Khandelwal’s Ward 7 Administrative Office.
* Includes: Office hours, telephone contact details, active social media handles, and an embedded interactive map for easy directions.
