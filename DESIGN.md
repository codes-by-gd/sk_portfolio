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

---

## 4. Frontend Single Page Layout & Sections

The homepage is a single-page scrolling interface with a sticky navigation bar.

### A. Sticky Navbar
- Uses daisyUI `navbar`.
- Contains: Name/Designation logo, scroll links (Home, About, Development Work, Achievements, Gallery, Contact), and the native language switcher dropdown (English, ગુજરાતી, हिन्दी).
- **CTA Button:** A prominent Call-to-Action button ("Give Feedback") is aligned on the right side of the navbar, linking directly to the standalone detailed feedback page.

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
  - **User Image:** Displays the optional user avatar (`avatar_path`) uploaded from the admin dashboard.
- **Detailed feedback CTA:** A centered, prominent button ("Submit Detailed Review") directing users to the standalone detailed feedback page.
- **No Quick Form:** The inline quick feedback form is completely removed.

---

## 5. Detailed Feedback Page (Separate Page Layout)

A standalone webpage optimized for mobile sharing via messaging links. It has two priority areas:

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
- **Mobile Photo Capture Button:** Stylized upload block. On mobile devices, clicking this button triggers the native device camera for quick snaps of local development or issues.

### B. Approved Feedbacks Listing (Secondary Focus)
- Placed below the form section to keep it clean.
- Displays a grid/list of all approved feedbacks (`status = 'approved'`) with star ratings, name, ward area, feedback title, date, and user-uploaded feedback images. Avatars and mobile numbers are omitted in this list for privacy and simplicity.

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
