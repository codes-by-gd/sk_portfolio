# DESIGN.md — UI/UX Design System & Layout Requirements

This document defines the design philosophy, visual assets, typography, color palette, and layout system. Implementation of the frontend single page, shareable detailed feedback page, and administrative dashboard must adhere to this system.

---

## 1. Design Philosophy
The user experience must feel modern, premium, trustworthy, and development-oriented. It should read like a high-end editorial biography or personal brand platform rather than a cluttered political poster. 
- **Core Principle:** Clean layout, generous white space, smooth micro-animations, and intuitive form control transitions.
- **Framework Constraint:** Compulsory use of **daisyUI components** for all UI building blocks (inputs, cards, stats, drawers, tables, carousels, ratings).

---

## 2. Typography & Color Palette

### Typography
- **Heading Font:** `Poppins` (editorial, modern, excellent Gujarati/Hindi rendering).
- **Body Font:** `Inter` (high legibility) with `Noto Sans` fallback.

### Candy Patriotic Color Palette & Ratios
- **Cream White (70%):** `#FFFDF8` (Background base, clean editorial look).
- **Primary Saffron (20%):** `#FF8A3D` (Branding, active state highlights, primary CTAs).
- **Ashoka Blue (7%):** `#3D5AFE` (Secondary actions, deep accents, badges).
- **Soft Green (3%):** `#53C58B` (Success alerts, status indicators, positive ratings).
- **Soft Black:** `#1E1E1E` (High-contrast text, borders, headers).

---

## 3. daisyUI Component Constraints

### Form Inputs & Floating Labels (Compulsory)
All text inputs, textareas, and selectors must use daisyUI styling coupled with peer-based CSS floating labels. No raw browser inputs are permitted.

#### HTML/CSS Floating Label Template:
```html
<!-- daisyUI Floating Label Text Input -->
<div class="form-control relative w-full">
  <input 
    type="text" 
    id="name" 
    placeholder=" " 
    class="input input-bordered peer pt-6 pb-2 w-full focus:outline-primary placeholder-shown:placeholder-transparent" 
    required 
  />
  <label 
    for="name" 
    class="label absolute left-4 top-2 text-xs text-base-content/60 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary pointer-events-none"
  >
    Full Name
  </label>
</div>
```

```html
<!-- daisyUI Floating Label Textarea -->
<div class="form-control relative w-full">
  <textarea 
    id="message" 
    placeholder=" " 
    rows="4" 
    class="textarea textarea-bordered peer pt-6 pb-2 w-full focus:outline-primary placeholder-shown:placeholder-transparent resize-none" 
    required
  ></textarea>
  <label 
    for="message" 
    class="label absolute left-4 top-2 text-xs text-base-content/60 transition-all peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:top-2 peer-focus:text-xs peer-focus:text-primary pointer-events-none"
  >
    Feedback Message
  </label>
</div>
```

---

## 4. Frontend Single Page Layout & Sections

The homepage is a single-page scrolling interface with a sticky navigation bar.

### A. Sticky Navbar
- Uses daisyUI `navbar`.
- Contains: Name/Designation logo, scroll links (Home, About, Development Work, Achievements, Feedback, Gallery, Contact), and the native language switcher dropdown (English, ગુજરાતી, हिन्दी).

### B. Hero Section
- **Layout:** Two-column grid (large screen) or stack (mobile).
- **Left Column:** Greeting, Name, BJP designation, mission statement, and primary CTA ("Share Your Feedback" scrolls to the feedback section, secondary CTA "View Development Work").
- **Right Column:** Premium portrait image with animated floating civic highlight tags (e.g. `badge badge-accent` style tags like *Road Development*, *Cleanliness*, *Water Supply*, *Healthcare*).

### C. About Section
- Editorial biography display with side-by-side content and images.

### D. Development Work Section
- Cards styled with daisyUI `card`.
- Displays dynamic images, tag locations, descriptions, and interactive before/after image sliders using daisyUI `diff` component where applicable.

### E. Achievements Section
- Styled using daisyUI `stats` panel grid.
- Shows dynamic metrics like Completed Works, Welfare Campaigns, and Public Engagements.

### F. Public Feedback Section (Single Page Home)
- **Feedback Carousel:** Uses daisyUI `carousel` with cards displaying only approved reviews. Cards show citizen name, ward area, message, photo (if available), and rating.
- **Quick Feedback Form:** A compact version of the submission form with floating label inputs for quick comments.

---

## 5. Detailed Feedback Page (Separate Page Layout)

A standalone webpage optimized for mobile sharing via messaging links.

### Visual Architecture
- Simple, premium header (Sachin Khandelwal logo) and language switcher.
- Centered detailed card layout (`card w-full max-w-xl bg-base-100 shadow-xl border border-base-200`).
- **Interactive 5-Star Rating Component:** Built with daisyUI rating mask stars:
```html
<div class="rating rating-lg gap-1 flex justify-center py-2">
  <input type="radio" name="rating-2" class="mask mask-star-2 bg-warning" value="1" />
  <input type="radio" name="rating-2" class="mask mask-star-2 bg-warning" value="2" />
  <input type="radio" name="rating-2" class="mask mask-star-2 bg-warning" value="3" />
  <input type="radio" name="rating-2" class="mask mask-star-2 bg-warning" value="4" checked />
  <input type="radio" name="rating-2" class="mask mask-star-2 bg-warning" value="5" />
</div>
```
- **Mobile Photo Capture Button:** Stylized upload block. On mobile devices, clicking this button triggers the native device camera for quick snaps of local development or issues.

---

## 6. Admin Panel Design

The administrative backend dashboard utilizes a unified design matching the main site.

### Drawer Layout
- Uses daisyUI `drawer` (`drawer-mobile` layout).
- Left navigation sidebar contains the administrative menu list (`menu p-4 w-80 min-h-full bg-base-200 text-base-content`).
- Right content panel containing page headers, stats overview, and tables.

### Tables & Modals
- All table lists (feedback reviews, gallery media) styled with `table table-zebra w-full`.
- Approval and rejection quick action triggers pop open daisyUI `modal` confirmation boxes.
- Status badges use daisyUI colors (`badge-warning` for pending, `badge-success` for approved, `badge-error` for rejected).

---

## 7. Responsive & Mobile-First Guidelines (Compulsory)
- **Compulsory Responsiveness:** All views, forms, inputs, dashboard tables, and components (public frontend, standalone detailed feedback form, login screens, and administration controls) MUST be completely responsive and mobile-friendly by default. No element should cause layout overflow, horizontal scrolls, or component clipping on viewports ranging from 320px mobile to 4K monitors.
- Layouts must degrade gracefully to a single-column layout on mobile viewports.
- All buttons must meet target tap targets of at least `48px x 48px`.
- Form inputs must avoid auto-zooming on iOS (set appropriate font size).

---

## 8. Layout Separation Architecture (Frontend vs Backend)
- **Decoupled Layout Templates:** The public frontend and the administrative backend must utilize completely decoupled layout templates to prevent style bleed and retain different navigations.
  - **Public Layout (`layouts/app.blade.php`):** Standard single-page site container containing public navigation links, the citizen feedback carousel, and public footers.
  - **Admin Office Layout (`layouts/admin.blade.php`):** Fluid full-width admin portal container. It features a custom lock top header navbar (`Secure Admin Panel`), the admin sidebar navigation menu, session control forms, and translation components. It must never load public header or footer views.
