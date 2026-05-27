# DESIGN.md — UI/UX Design System & Layout Requirements

This document defines the design philosophy, visual assets, typography, color palette, and layout system. Implementation of the frontend single page, shareable detailed feedback page, and administrative dashboard must adhere to this system.

---

## 🗺️ Documentation Suite & AI Context Map

*To ensure strict architectural and design alignment, all AI coding agents must reference and adhere to the following unified project documentation suite:*

* 📄 **[README.md](./README.md)** — Standard repository overview, environment configuration, and agentic development tools.
* 📋 **[Requirement.md](./Requirement.md)** — Master index mapping functional specifications and modular requirements.
* ⚙️ **[AGENT.md](./AGENT.md)** — Technical development specifications, PHP 8.4 setup details, SQL database columns, and backend routing/controllers.
* 🎨 **[DESIGN.md](./DESIGN.md) (You are here)** — UX/UI Design system, semantic light/dark patriotic themes, daisyUI v5 layouts, fixed-height viewport rules, and official civic branding guidelines.
* 🛠️ **[DAISYUI.md](./DAISYUI.md)** — Comprehensive daisyUI 5 rules, class lists, and components reference (utilized as an LLM system-level skill).

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

### Semantic Patriotic Color Palette & Themes
The application utilizes daisyUI v5 semantic tokens to power full responsiveness to dark mode. The color mapping is decoupled from hardcoded inline rules.

#### A. Patriotic Light Theme (`patriotic-theme`)
- **Primary Saffron:** `#FF8A3D` (Branding, active state highlights, primary CTAs).
- **Secondary Slate-Blue:** `#2B3E50` (Secondary actions, deep accents, badges).
- **Base Background:** `#FFFDF8` (Cream base background for clean editorial contrast).
- **Base Content:** `#1E1E1E` (Sleek off-black text and borders).
- **Base Border (`--border`):** `1px` (Base component border width, ensuring crisp, thin outlines).

#### B. Patriotic Dark Theme (`patriotic-dark`)
- **Primary Saffron:** `#FF9E5C` (Higher contrast saffron highlight in dark viewports).
- **Secondary Slate-Blue:** `#3D536B` (Softer slate-blue container panels).
- **Base Background:** `#121212` (Low-glare deep charcoal dark mode background).
- **Base Content:** `#F7F7F7` (High legibility off-white text).
- **Base Border (`--border`):** `1px` (Base component border width for low-glare visual outlines).

---

## 3. daisyUI Component Constraints

### Form Inputs & Floating Labels (Compulsory)
All text inputs, textareas, and selectors must use daisyUI styling coupled with peer-based CSS floating labels. No raw browser inputs are permitted. To ensure maximum reusability and eliminate redundant code, use the custom Blade component `<x-float-input />`.

#### Reusable float-input Component:
```html
<x-float-input 
    type="text" 
    name="username" 
    label="Username" 
    required="true"
/>
```

#### Supported Options:
- **`type`**: Input type (`text`, `email`, `password`, `tel`, etc. - default: `text`).
- **`name`**: Form input name.
- **`value`**: Initial input value.
- **`label`**: Floating label text content.
- **`required`**: Whether field is required (`true` or `false`).
- **`inputClass`**: Extra input classes (default is transparent border).
- **`labelClass`**: Extra label classes (default responds to primary theme color).

### Custom Interactive Star Rating with Floating Label (Compulsory)
When an interactive star-rating input is required within a form (e.g., in the administrative feedback edit pane), it must feature a fully native, matching floating label and border alignment. To preserve focus highlight and border transition consistency with `<x-float-input />` fields, structure it using a direct sibling input wrapper with standard Tailwind state triggers:

#### Rating Form Control Structure:
```html
<div class="form-control sm:col-span-1">
    <label class="floating-label w-full block group relative">
        <span class="group-focus-within:text-primary transition-colors duration-200">
            Rating <span class="text-error font-extrabold">*</span>
        </span>
        <!-- Sibling input to trigger DaisyUI floating label CSS natively -->
        <input 
            type="text" 
            placeholder="Rating"
            class="input input-md w-full bg-base-100 border border-base-300 rounded-xl pointer-events-none select-none text-transparent transition-all duration-200 group-hover:border-base-content/30 group-focus-within:border-primary group-focus-within:ring-1 group-focus-within:ring-primary"
            style="color: transparent; caret-color: transparent;"
            readonly
            value="Rating"
        />
        <!-- Direct Interactive Stars absolute overlay -->
        <div class="absolute inset-x-0 bottom-0 h-12 flex items-center justify-center rating rating-md gap-0.5 pointer-events-auto z-20">
            <input type="radio" name="rating" value="1" class="mask mask-star-2 bg-warning transition-transform hover:scale-110 cursor-pointer" required />
            <input type="radio" name="rating" value="2" class="mask mask-star-2 bg-warning transition-transform hover:scale-110 cursor-pointer" required />
            <input type="radio" name="rating" value="3" class="mask mask-star-2 bg-warning transition-transform hover:scale-110 cursor-pointer" required />
            <input type="radio" name="rating" value="4" class="mask mask-star-2 bg-warning transition-transform hover:scale-110 cursor-pointer" required />
            <input type="radio" name="rating" value="5" class="mask mask-star-2 bg-warning transition-transform hover:scale-110 cursor-pointer" required />
        </div>
    </label>
</div>
```

#### Alignment & State Syncing Rules:
- **Direct Sibling Structure**: The text `<input>` and the label `<span>` must remain direct children of `.floating-label` to trigger DaisyUI’s `:has` selectors natively.
- **Active Focus & Hover Syncing**: The container `<label>` must have the `group` class, and the dummy background input must use `group-hover:border-base-content/30` and `group-focus-within:border-primary` transitions. This guarantees that when a user hovers or clicks a star, the input outline and the label color instantly transition to their active/focused styles in unison.
- **Asynchronous JS Value Loader**: When populating form values dynamically (e.g. inside an edit modal), use Javascript to check the corresponding radio element inside the overlay rather than assigning to a selector:
  ```javascript
  const ratingRadios = form.querySelectorAll('input[name="rating"]');
  ratingRadios.forEach(radio => {
      if (radio.value == feedback.rating) {
          radio.checked = true;
      }
  });
  ```

### Multilingual Input Grid Layouts (Compulsory)
To facilitate simultaneous translation editing, reading, and comparison, all multilingual text fields must display English, Gujarati, and Hindi inputs together side-by-side rather than hidden behind toggles or tabs.

#### 1. Responsive 3-Column Row
Group the 3 translation fields inside a responsive grid row that automatically switches from side-by-side comparisons on desktop to clean vertical stacks on mobile viewports:
```html
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    <!-- English input -->
    <div class="relative">...</div>
    <!-- Gujarati input -->
    <div class="relative">...</div>
    <!-- Hindi input -->
    <div class="relative">...</div>
</div>
```

#### 2. Visual Language Indicator Badges
Every multilingual input field must display a color-coded language badge in its upper-right corner for high-visibility visual contrast:
* **English (EN) Badge:**
  `badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]` (Slate-blue or Primary saffron accent).
* **Gujarati (GU) Badge:**
  `badge badge-xs bg-secondary/15 border-secondary/20 text-secondary font-bold text-[9px]` (Slate-blue accent).
* **Hindi (HI) Badge:**
  `badge badge-xs bg-accent/15 border-accent/20 text-accent font-bold text-[9px]` (Accent saffron highlight).

*Code snippet example inside a grid cell:*
```html
<div class="relative">
    <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
    <x-float-input type="text" name="content[field_key][content_en]" label="Field Name (English)" value="..." required="true" />
</div>
```

#### 3. Multilingual Textareas
Longer multilingual texts must use stylized textareas aligned side-by-side within the 3-column layout. Use a unified block class wrapper `floating-label w-full block` around textareas for smooth floating-label states matching `DESIGN.md`:
```html
<div class="form-control relative">
    <span class="absolute top-2 right-3 z-10 badge badge-xs bg-primary/15 border-primary/20 text-primary font-bold text-[9px]">EN</span>
    <label class="floating-label w-full block">
        <span>Description (EN) <span class="text-error font-extrabold">*</span></span>
        <textarea name="content[key][content_en]" required rows="3" class="textarea textarea-md w-full bg-base-100 text-base-content border border-base-300 rounded-xl focus:outline-none focus:border-primary transition-all h-28">...</textarea>
    </label>
</div>
```

---

## 4. Frontend Single Page Layout & Sections

The homepage is a single-page scrolling interface with a sticky navigation bar.

### A. Sticky Navbar
- Uses daisyUI `navbar`.
- Contains: Name/Designation logo, scroll links (Home, About, Development Work, Achievements, Gallery, Contact), and the native language switcher dropdown (English, ગુજરાતી, हिन्दी).

### B. Hero Section
- **Layout:** Two-column grid (large screen) or stack (mobile).
- **Left Column:** Greeting, Name, BJP designation, mission statement, and primary CTA ("Share Your Feedback" redirects to the detailed feedback page, secondary CTA "View Development Work").
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
- **Featured Carousel:** Uses daisyUI `carousel` displaying only featured feedback entries (`is_featured = true` and `status = 'approved'`).
  - **Listing Density:** Displays multiple feedback cards next to each other on larger viewports (e.g. 3 cards per slide/grid) to show more content together.
  - **User Avatar:** Displays elegant visual fallback initials based on the user's name.
- **Detailed feedback CTA:** A centered, prominent button ("Submit Detailed Review") directing users to the standalone detailed feedback page.
- **No Quick Form:** The inline quick feedback form is completely removed.

---

## 5. Detailed Feedback Page (Separate Page Layout)

As standalone webpage optimized for mobile sharing via messaging links. It has two priority areas:

### A. Detailed Feedback Form (Primary Focus)
- Centered detailed card layout (`card w-full max-w-xl bg-base-100 shadow-xl border border-base-200`) positioned at the top of the page.
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

### B. Approved Feedbacks Listing (Secondary Focus)
- Placed below the form section to keep it clean.
- Displays a grid/list of all approved feedbacks (`status = 'approved'`) with star ratings, name, ward area, and date. Mobile numbers are omitted in this list for privacy, and dynamic initials-based avatars are rendered.

---

## 6. Admin Panel Design

The administrative backend dashboard utilizes a unified design matching the main site.

### Drawer Layout
- Uses daisyUI `drawer` (`drawer-mobile` layout).
- Left navigation sidebar contains the administrative menu list (`menu p-4 w-80 min-h-full bg-base-200 text-base-content`).
- Right content panel containing page headers, stats overview, and tables.

### Module-Specific View Architectures
To keep the codebase cleanly organized and prevent generic template overlaps:
- **Feedback Module:** The core feedback management dashboard must be located at `resources/views/admin/feedback.blade.php` (renamed from `dashboard.blade.php`).
- **Gallery Module:** The gallery management view is located at `resources/views/admin/gallery/index.blade.php`.
- **Development Works Module:** The development works list view is located at `resources/views/admin/development/index.blade.php`.

### Tables & Modals
- All table lists (feedback reviews, gallery media) styled with `table table-zebra w-full`.
- Approval and rejection quick action triggers pop open daisyUI `modal` confirmation boxes.
- Status badges use daisyUI colors (`badge-warning` for pending, `badge-success` for approved, `badge-error` for rejected).
- **Action Buttons Layout & Styling Rules (Compulsory):**
  - **Edit Actions:** All edit operations (whether navigating to a dedicated edit page or opening an in-page editing popup modal) must use **`btn-info`** (e.g. `class="btn btn-sm btn-square btn-soft btn-info"`) with a pen icon (`fa-solid fa-pen` or `fa-solid fa-pen-to-square`).
  - **Delete Actions:** All deletion operations must use **`btn-error`** (e.g. `class="btn btn-sm btn-square btn-soft btn-error"`) with a trash icon (`fa-solid fa-trash-can`).
  - **Approval Actions:** Quick approval table buttons must use **`btn-success`** (e.g. `class="btn btn-sm btn-square btn-soft btn-success"`).
  - **Rejection Actions:** Quick rejection table buttons must use **`btn-error`** (e.g. `class="btn btn-sm btn-square btn-soft btn-error"`).
  - **Tooltips:** All square action buttons must feature a top-positioned descriptive tooltip using the daisyUI `tooltip tooltip-top` structure (e.g. `data-tip="Edit Details"`).
  - **Standardized Action Button Sequence (Predictable Layout Alignment):**
    To ensure a visually consistent, non-shifting table layout that protects against misclicks across varying statuses, the action buttons in the admin table must ALWAYS follow a strict and uniform order from left to right:
    1. `Approve Action` (`btn-success` soft, shown if status is not approved)
    2. `Reject Action` (`btn-error` soft, shown if status is not rejected)
    3. `Feature/Unfeature Action` (`btn-warning` soft/solid, shown if approved)
    4. `Edit/Modify Details` (`btn-info` soft, always shown, pinned to the right)
    5. `Delete Permanently` (`btn-error` soft, always shown, pinned to the far-right edge)
    This order ensures that the core modification utilities (Edit and Delete) remain perfectly aligned side-by-side on the rightmost edge of every list item.
  - **Unified Same-Page Lightbox Viewer for Images & Attachments:**
    All admin-side image previews (both within list tables and modal detail sheets) must not open in new browser tabs (`target="_blank"`). Instead, clicking any preview must open a high-resolution version inside a premium, native HTML5 same-page Lightbox Dialog (`<dialog id="viewer-modal">`) featuring an overlay blur, quick close operations, and category/caption text.

### Sidebar User Profile Link
- The username container in the sidebar under "Logged In As" is converted to a premium menu-like interactive block targeting the profile page.
- Renders a circular **User Avatar** block inside. If no custom image is uploaded, it automatically displays the initials fallback based on `first_name` and `last_name` (e.g. "SK").
- Highlights with standard sidebar menu styles (`hover:bg-white/5` on hover, and solid `bg-primary` gradient highlight with `bg-white text-primary` active avatar rings when currently active on the Profile page).
- Hovering over this container triggers a smooth transition: the text turns white, and a sleek edit icon (`fa-solid fa-pen-to-square`) is revealed next to the name.

### Profile Edit Page Layout
- Uses the standard admin layouts matching the primary and dark modes.
- Styled using the standard `.card-base` card component class, split into two primary panels: Profile Details (featuring a premium circle avatar upload preview container and separate **First Name** and **Last Name** floating inputs) and Password Update.
- Integrates the custom `<x-float-input />` floating label component for all field actions, ensuring visual harmony and mobile friendliness.

---

## 7. Responsive & Mobile-First Guidelines (Compulsory)
- **Compulsory Responsiveness:** All views, forms, inputs, dashboard tables, and components (public frontend, standalone detailed feedback form, login screens, and administration controls) MUST be completely responsive and mobile-friendly by default. No element should cause layout overflow, horizontal scrolls, or component clipping on viewports ranging from 320px mobile to 4K monitors.
- Layouts must degrade gracefully to a single-column layout on mobile viewports.
- All buttons must meet target tap targets of at least `48px x 48px`.
- Form inputs must avoid auto-zooming on iOS (set appropriate font size).

### Mobile-Specific Implementation Patterns

#### A. Hero CTA Button Stacking (Compulsory)
When two side-by-side CTA buttons are in the hero section, they MUST stack vertically on mobile and go side-by-side on `sm:` breakpoint (640px+):
```html
<div class="flex flex-col sm:flex-row flex-wrap justify-center lg:justify-start gap-3 sm:gap-4">
    <a class="btn btn-primary btn-md sm:btn-lg ...">Primary CTA</a>
    <a class="btn btn-outline btn-secondary btn-md sm:btn-lg ...">Secondary CTA</a>
</div>
```

#### B. Category Filter Tabs — Horizontal Scroll on Mobile
Category filter tabs (gallery, development categories) must use a horizontally-scrollable row on mobile and wrapped flex on `sm:` viewports. Always add `shrink-0` and `snap-start` to individual tab buttons:
```html
<div class="flex sm:flex-wrap overflow-x-auto sm:overflow-visible sm:justify-center gap-2 pb-1 sm:pb-0 snap-x"
     style="-webkit-overflow-scrolling: touch; scrollbar-width: none;">
    <button class="btn btn-sm gallery-tab-btn shrink-0 snap-start" ...>Tab Label</button>
</div>
```

#### C. Pagination — Flex-Wrap + Max Width Constraint
Pagination number containers must always use `flex-wrap` to prevent overflow when many pages exist. Wrap inside a `max-w-[calc(100vw-8rem)]` to ensure prev/next buttons stay within viewport:
```html
<div class="flex flex-wrap justify-center items-center gap-2">
    <button class="btn btn-sm btn-circle shrink-0">←</button>
    <div class="flex flex-wrap justify-center gap-1.5 max-w-[calc(100vw-8rem)]" id="page-numbers"></div>
    <button class="btn btn-sm btn-circle shrink-0">→</button>
</div>
```

#### D. Section Padding — Mobile Reduction
Large desktop section paddings (`py-24`, `p-8`, `p-12`) must scale down on mobile. Use responsive padding prefixes:
- `py-16 sm:py-24 lg:py-40` for hero sections
- `p-4 sm:p-8` for stat/metric blocks
- `p-5 sm:p-8 md:p-12` for carousel containers

#### E. Navbar Brand Shrink
On mobile (`< sm`), the navbar brand must only show the SK badge + first name (no designation subtitle). The subtitle span must use `hidden sm:flex` to hide on tiny screens. Badge size should be `w-9 h-9 sm:w-10 sm:h-10`:
```html
<span class="font-heading font-extrabold text-base sm:text-lg ...">Sachin Khandelwal</span>
<span class="hidden sm:flex items-center gap-1 ...">BJP Adhyaksh · Ward 7</span>
```

---

## 8. Layout Separation Architecture (Frontend vs Backend)
- **Decoupled Layout Templates:** The public frontend and the administrative backend must utilize completely decoupled layout templates to prevent style bleed and retain different navigations.
  - **Public Layout (`layouts/app.blade.php`):** Standard single-page site container containing public navigation links, the citizen feedback carousel, and public footers.
  - **Admin Office Layout (`layouts/admin.blade.php`):** Fluid full-width admin portal container. It features a custom lock top header navbar (`Secure Admin Panel`), the admin sidebar navigation menu, session control forms, and translation components. It must never load public header or footer views.

---

## 9. Admin Panel Viewport Layout Architecture (Fixed Chrome + Scroll-Isolated Content)

The admin panel must **never overflow the browser viewport**. The entire shell is locked to `100vh`, and only the main content area is scrollable.

### Layout Constraints
- **`<html>` and `<body>`:** Set to `h-full` / `h-screen` with `overflow: hidden`. This prevents any page-level scroll; all scrolling is delegated to the main content column only.
- **Patriotic Ribbon:** `position: fixed; top: 0; z-index: 60` — a thin decorative stripe pinned to the very top of the viewport at all times.
- **Top Navbar (`<header>`):** `position: fixed; top: 1.5 (ribbon height); z-index: 50` — always visible, never scrolls away. Implements the `Secure Admin Panel` chrome.
- **Content Shell (`<div>` below header):** Uses `padding-top: calc(ribbon height + navbar height)` to push content below the fixed chrome, and `height: calc(100vh - ribbon height)` to fill the remaining viewport exactly.

### Sidebar Rules
- The sidebar (`<aside>`) is **never sticky or fixed with CSS position**; instead it is a flex child of the full-height content shell, giving it a natural fixed-height equal to the remaining viewport.
- `overflow-y: auto` on the sidebar allows internal sidebar scroll if the nav links exceed the available height, without affecting the page.
- On mobile (`< lg` breakpoint) the sidebar is `hidden`; a mobile nav strategy (drawer/hamburger) should be used if required.
- The sidebar must **never extend below the viewport**, nor push the footer outside the visible area.

### Main Content Scrolling
- Only `<main>` has `overflow-y: auto`, making it the sole scrollable region.
- The content column uses `flex flex-col overflow-hidden` so that `<main>` + `<footer>` together exactly fill the remaining height.

### Footer Rules
- The admin footer is placed **inside the content column** (`<div class="flex-grow flex flex-col ...">`) as a `shrink-0` child **after** `<main>`.
- The footer must **never appear below the sidebar** — it is scoped only to the right-hand content area.
- Because only `<main>` scrolls, the footer is always pinned at the bottom of the content column and visible without scrolling (unless the viewport is extremely small).

### Summary Table

| Element          | Position Strategy | Scrolls? | Notes                                    |
|------------------|-------------------|----------|------------------------------------------|
| Ribbon           | `fixed` (z-60)    | No       | 1.5 rem tall stripe                      |
| Navbar           | `fixed` (z-50)    | No       | Pushed 1.5 rem below ribbon              |
| Sidebar          | Flex child        | Internal | `overflow-y-auto`, full remaining height |
| Main Content     | Flex child        | **Yes**  | Only scrollable region                   |
| Footer           | Flex child        | No       | `shrink-0`, inside content column only   |

---

## 10. Dark Mode & Theme Switching Control
The application supports persistent dark mode via daisyUI themes mapped to a root-level attribute.
- **Theme Activation:** Managed by assigning `data-theme` to the `<html>` element.
  - Light mode: `data-theme="patriotic-theme"`
  - Dark mode: `data-theme="patriotic-dark"`
- **Anti-Flash Implementation:** To prevent screen flash on initial render, a blocking inline script is placed in the HTML `<head>` *prior* to parsing styles. It immediately reads the localStorage key `sk-theme` and applies the theme:
```javascript
(function() {
    const savedTheme = localStorage.getItem('sk-theme') || 'patriotic-theme';
    document.documentElement.setAttribute('data-theme', savedTheme);
})();
```
- **Sync Toggles:** All interactive theme toggles (such as header icons) must swap the `data-theme` attribute and write the selected value back to `localStorage` under `sk-theme`.

---

## 11. Visual Integrity, Shadows & Cards (.card-base)
To avoid high-contrast jarring visual borders, the design mandates soft shadows and ambient styling.
- **Strict Constraint:** Never use harsh black border utilities (`border-black` or `border-neutral`).
- **Unified Card Utility (`.card-base`):** Use the standard `.card-base` class defined in global CSS:
```css
.card-base {
    border-color: var(--color-base-300);
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05), 0 2px 8px -1px rgba(0, 0, 0, 0.03);
}
[data-theme="patriotic-dark"] .card-base {
    border-color: rgba(255, 255, 255, 0.08);
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.35);
}
```
- Applying `.card-base` ensures consistent responsiveness, giving containers elegant ambient light borders in light mode and switching automatically to glowing, low-glare shadows in dark mode.

---

## 12. Civic Branding System (Frontend Public Site)

This section documents the BJP and civic identity design language applied to the public frontend. Future agents must follow these guidelines strictly to maintain the **"Modern Civic Leadership"** tone — never slipping into **"Campaign Poster"** style.

### Core Branding Principle
> The primary identity is **Sachin Khandelwal** (personal civic leader).
> The BJP association **supports** the identity — it never overpowers it.
> No official Government of India emblem (Lion Capital / 4-lion Ashoka) may be used — protected under the State Emblem of India Act.

---

### Phase 1 — Identity & Logo (Implemented)

#### A. SK Monogram Badge (Navbar — `layouts/app.blade.php`)
- The SK badge uses a **saffron diagonal gradient** (`#FF8A3D → #e8651a`) instead of a flat `bg-primary`.
- Shadow: `shadow-lg shadow-orange-400/30` for warm ambient glow.
- An **8-petal lotus SVG ring** (white petals, `opacity-[0.18]`) is absolutely-positioned inside the badge as a subtle BJP identity hint — not a full logo.
- Badge dimensions: `w-10 h-10 rounded-xl`.
- Do NOT replace this with an image-based logo without design review.

```html
<!-- Lotus petal ring inside SK badge -->
<svg class="absolute inset-0 w-full h-full opacity-[0.18] pointer-events-none" viewBox="0 0 40 40" fill="none">
  <ellipse cx="20" cy="8" rx="3.5" ry="7" fill="white" transform="rotate(N 20 20)"/>
  <!-- 8 petals at 0°, 45°, 90°, 135°, 180°, 225°, 270°, 315° -->
</svg>
```

#### B. Navbar Brand Subtitle (Navbar — `layouts/app.blade.php`)
- Subtitle changed from plain `"VADODARA WARD 7"` to `"BJP Adhyaksh · Ward 7"`.
- Prefixed by a **6-petal micro lotus SVG** (`w-2.5 h-2.5`) in `text-primary`.
- Uses `text-[10px] font-extrabold tracking-wide text-primary` — consistent with existing brand color.

#### C. Hero Greeting Badge (Landing Page — `landing.blade.php`)
- The greeting badge (`"NAMASTE & WELCOME"`) uses a **6-petal micro lotus SVG** (`w-3 h-3`) instead of the previous `fa-solid fa-star` icon.
- Color: `text-primary` (saffron), inline SVG.

#### D. Hero BJP Designation Pill (`landing.blade.php`)
- A dedicated designation pill is placed directly below the `<h1>` tag in the hero section.
- Style: `inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-primary/25 bg-primary/5 text-sm font-semibold text-primary`
- Prefixed by the same 6-petal lotus SVG (`w-3.5 h-3.5`).
- Text: `"BJP Adhyaksh & Corporator · Vadodara Ward No. 7"`
- This gives the BJP signal in the hero without a full party logo.

---

### Phase 2 — Visual Identity Polish (Implemented)

#### E. Laxmi Vilas Palace Silhouette Watermark (Hero — `landing.blade.php`)
- An SVG architectural silhouette of Laxmi Vilas Palace is placed as a **background watermark** in the hero section.
- Positioning: `absolute bottom-0 right-0`, `overflow-hidden`, `opacity-[0.035]`, `text-base-content` (inherits theme color automatically).
- Size: `w-[520px]` — visible on desktop, clips gracefully on mobile.
- Elements: Symmetrical palace with 2 main towers + 2 flanking small towers, central Indo-Saracenic dome with finial, crenellations, 3 arched windows.
- Purpose: Establishes Vadodara local identity without any political symbol.
- **Do NOT increase opacity above `0.06`** — it must remain a subtle watermark only.

#### F. Saffron Radial Hero Glow (`landing.blade.php`)
- A radial gradient overlay is added to the hero section: `bg-[radial-gradient(ellipse_at_top_right,rgba(255,138,61,0.07),transparent_55%)]`
- Placed as `absolute inset-0 pointer-events-none` inside the hero section.
- Adds editorial depth and warmth to the hero background.

#### G. Ashoka Chakra-Inspired Section Dividers (`landing.blade.php`)
- All section heading divider bars (`w-24 h-1 bg-primary`) have been replaced with a 3-part decorative divider:
  - Left: `h-px w-20 bg-gradient-to-r from-transparent to-primary/60 rounded-full`
  - Center: A **12-spoke wheel SVG** inspired by the Ashoka Chakra (`w-5 h-5 text-secondary/40`)
  - Right: `h-px w-20 bg-gradient-to-l from-transparent to-primary/60 rounded-full`
- The wheel SVG uses: outer circle (`r=10.5`), filled center hub (`r=2`), and 6 diameter lines creating 12 spoke ends.
- Color: `text-secondary/40` (Ashoka navy blue) on light sections, `text-white/30` on the dark Achievements section.
- **This is NOT the official Ashoka government emblem** — it is a simplified stylized wheel for decorative use only.

```html
<!-- Reusable Ashoka Chakra divider pattern -->
<div class="flex items-center justify-center gap-3 mt-4">
    <div class="h-px w-20 bg-gradient-to-r from-transparent to-primary/60 rounded-full"></div>
    <svg class="w-5 h-5 text-secondary/40 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.7">
        <circle cx="12" cy="12" r="10.5"/>
        <circle cx="12" cy="12" r="2" fill="currentColor" stroke="none"/>
        <line x1="22.5" y1="12" x2="1.5" y2="12"/>
        <line x1="21.1" y1="6.8" x2="2.9" y2="17.2"/>
        <line x1="17.3" y1="2.9" x2="6.7" y2="21.1"/>
        <line x1="12" y1="1.5" x2="12" y2="22.5"/>
        <line x1="6.7" y1="2.9" x2="17.3" y2="21.1"/>
        <line x1="2.9" y1="6.8" x2="21.1" y2="17.2"/>
    </svg>
    <div class="h-px w-20 bg-gradient-to-l from-transparent to-primary/60 rounded-full"></div>
</div>
```

#### H. CTA Button Glow Enhancement (`landing.blade.php`)
- Primary hero CTA now has: `shadow-lg shadow-primary/20 hover:shadow-xl hover:shadow-primary/35 hover:-translate-y-0.5 transition-all duration-200`
- Secondary CTA now has: `hover:shadow-md hover:shadow-secondary/20`
- The lift effect (`hover:-translate-y-0.5`) gives a premium interactive feel without being distracting.

---

### Branding Quick Reference — What to Use Where

| Element | Location | Notes |
|---|---|---|
| 8-petal lotus SVG ring | SK navbar badge (inside) | `opacity-[0.18]`, white, decorative only |
| 6-petal micro lotus SVG | Navbar subtitle · Hero greeting badge · Hero designation pill | `text-primary` saffron fill |
| BJP designation pill | Hero section below `<h1>` | Outlined saffron pill, non-aggressive |
| Palace watermark | Hero section background | `opacity-[0.035]`, absolute, `text-base-content` |
| Ashoka Chakra divider | All 6 section headings | 12-spoke SVG, `text-secondary/40` |
| Saffron glow | Hero background radial | `rgba(255,138,61,0.07)` max |

### Strict Avoidance List
- ❌ Government Lion Capital / 4-lion Ashoka emblem — legally protected
- ❌ Giant BJP full logo as background or hero banner
- ❌ Repeating lotus tile patterns
- ❌ Indian national flag as texture, button, or animation
- ❌ 3D political emblems or glowing election-banner graphics

---

## 13. Performance Optimization Guidelines (Compulsory)

To maintain a premium, ultra-responsive feel (Lighthouse score of 95+), the implementation must strictly follow these performance-first guidelines.

### A. Asset Loading & Core Web Vitals
- **Deferred Rendering & Script Execution:** Load all non-critical scripts (Alpine.js, FontAwesome, etc.) with `defer` or `async` tags to prevent blocking the HTML parser.
- **Font Optimization:** Host Google Fonts (`Poppins` and `Inter`) locally or use high-performance preconnect headers to optimize First Contentful Paint (FCP):
  ```html
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  ```
- **SVG over Icon Fonts:** For branding elements, custom lotus designs, and dividers, use inline SVGs instead of loading heavy external icon sets.

### B. Image & Media Optimization
- **Modern File Formats:** All user-uploaded media (portraits, gallery images, before/after development works) must be converted and saved in **WebP or AVIF** format with an 80% compression threshold on upload.
- **Image Scaling & Srcset:** Implement explicit `width` and `height` dimensions on all standard images to avoid layout shifts (Cumulative Layout Shift - CLS). Render responsive sizes using standard Tailwind responsive utility tags.

### C. CSS & DOM Size Reduction
- **Clean DaisyUI Syntax:** Avoid redundant Tailwind inline class chains by using built-in DaisyUI component wrappers (e.g., `btn-soft`, `floating-label`, `card-base`). This keeps the DOM tree clean and significantly reduces CSS bundle size.
- **GPU-Accelerated Animations:** All transitions, hover lifts, and modal animations must utilize GPU-accelerated attributes (`transform`, `opacity`, `translate`). Avoid animating layout properties (`height`, `width`, `top`, `margin`) to prevent constant page reflows.

### D. Backend Database & Caching Optimization
- **Avoid N+1 Queries:** When displaying listings (such as the citizen reviews, achievements, or works list), ensure all database relations (e.g., tags, creator profiles) are eager-loaded:
  ```php
  $feedbacks = Feedback::where('status', 'approved')->paginate(12);
  ```
- **Indexed Fields:** Maintain database indexes on frequently filtered or ordered fields, including `status`, `is_featured`, `created_at`, and `category_id`.
- **Production Caching Pipeline:** In the production environment, always trigger Laravel's compiler caches:
  - Route compilation: `php artisan route:cache`
  - Config compilation: `php artisan config:cache`
  - View pre-rendering: `php artisan view:cache`


