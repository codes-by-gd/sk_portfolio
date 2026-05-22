# Sachin Khandelwal — Official Public Website

# Updated Detailed Website Requirement & Planning Document

Based on the updated requirements, this project is now defined as:

```text id="u5kzv5"
A multilingual single-page public leadership website
for Sachin Khandelwal,
BJP Adhyaksh & Corporator,
Vadodara Ward No. 7.
```



---

# 1. Project Identity

## Website Owner

```text id="4fyjlwm"
Sachin Khandelwal
```

Designation:

* BJP Adhyaksh
* Corporator
* Vadodara Ward No. 7

---

# 2. Website Purpose

The website is intended to function as:

* a public leadership identity platform
* a civic engagement portal
* a citizen feedback platform
* a development showcase website
* a public trust-building platform

---

# 3. Website Architecture

# IMPORTANT UPDATE

The frontend website must be:

```text id="jlwm3g"
Single Page Website (SPA-style experience)
```

NOT a traditional multi-page website.

---

# 4. Single Page Frontend Structure

The entire public website will exist on:

```text id="5jlwmf"
one scrolling landing page
```

with smooth navigation between sections.

---

# Frontend Navigation Sections

Navbar menu scrolls to sections:

```text id="jlwmt7"
Home
About
Development Work
Achievements
Gallery
Contact
```

Additionally, the right side of the navigation bar features a prominent Call-to-Action (CTA) button ("Give Feedback") leading directly to the standalone detailed feedback page.

---

# Navigation Behavior

Requirements:

* smooth scrolling
* sticky navbar
* active section highlighting
* responsive mobile menu
* modern transitions

---

# 5. Multilingual Requirement

# CORE REQUIREMENT

The website must fully support:

```text id="jlwm5z"
English
ગુજરાતી (Gujarati)
हिन्दी (Hindi)
```

across the frontend website.

---

# Multilingual Support Scope

The following content must support all 3 languages:

* Hero section
* About section
* Development work
* Achievements
* Feedback section headings
* Gallery content
* Contact details
* CMS content
* Navigation labels
* Footer content

---

# Language Strategy

## Primary Public Language

```text id="5jlwmv"
Gujarati
```

## Secondary

```text id="5jlwm0"
Hindi
```

## Third

```text id="2jlwmr"
English
```

---

# Language Switcher Requirement

Frontend must include:

* elegant language switcher
* desktop + mobile support
* native language labels

Example:

```text id="6jlwmx"
English
ગુજરાતી
हिन्दी
```

---

# Localization Architecture

Backend must use:

```text id="jlwm0m"
Laravel Localization
```

Structure:

```text id="7jlwmk"
resources/lang/en
resources/lang/gu
resources/lang/hi
```

---

# 6. Frontend Design Direction

# Design Philosophy

The website should feel:

```text id="xjlwmf"
Modern
Premium
Trustworthy
Ground-connected
Development-focused
Minimal
Youthful
Professional
```

---

# Design Inspiration

Inspired by:

* editorial portfolio websites
* premium personal branding
* civic leadership platforms

NOT:

* election posters
* loud political websites
* crowded government portals

---

# 7. Hero Section Planning

# Main Hero Section

This becomes:

```text id="4jlwm5"
the signature identity section
```

---

# Hero Layout

## Left Side

Contains:

* greeting
* Sachin Khandelwal name
* designation
* mission statement
* CTA buttons

Example:

```text id="7jlwmm"
Serving the people of
Vadodara Ward No. 7

Sachin Khandelwal

BJP Adhyaksh & Corporator

Committed to development,
public welfare,
and transparent leadership.
```

---

# CTA Buttons

Primary:

```text id="jlwm0a"
Share Your Feedback
```

Secondary:

```text id="7jlwm9"
View Development Work
```

---

# Right Side

Large premium portrait image.

Recommended image style:

* professional portrait
* soft lighting
* grayscale with saffron tint
* clean background
* confident expression

Avoid:

* poster-style images
* rally-stage images
* folded-hands political poses

---

# Floating Civic Highlight Tags

Animated floating tags around portrait:

```text id="5jlwm6"
Road Development
Cleanliness
Water Supply
Street Lighting
Healthcare
Women Empowerment
Youth Support
Public Welfare
```

---

# 8. Regional & BJP Identity Integration

# Vadodara Identity

Use subtle:

* Vadodara skyline references
* Gujarati design aesthetics
* civic textures
* local visual identity

---

# BJP Identity

Use:

* saffron accents
* disciplined branding
* governance-oriented messaging

Avoid:

* excessive lotus branding
* loud political graphics
* aggressive propaganda styling

---

# 9. Color Palette

# Candy Patriotic Palette

---

## Primary Saffron

```css id="jlwm8n"
#FF8A3D
```

---

## Cream White

```css id="2jlwmw"
#FFFDF8
```

---

## Ashoka Blue

```css id="7jlwml"
#3D5AFE
```

---

## Soft Green

```css id="1jlwm7"
#53C58B
```

---

## Soft Black

```css id="5jlwmn"
#1E1E1E
```

---

# Color Usage Ratio

```text id="jlwmj4"
70% cream white
20% saffron
7% blue
3% green
```

---

# 10. Typography System

# Recommended Fonts

## Heading Font

```text id="9jlwm7"
Poppins
```

Reason:

* modern
* multilingual friendly
* Gujarati/Hindi support

---

## Body Font

```text id="9jlwmn"
Inter
```

Fallback:

```text id="6jlwmj"
Noto Sans
```

---

# 11. Frontend Sections

# A. Hero Section

* portrait
* branding
* CTA

---

# B. About Sachin Khandelwal

Contains:

* biography
* BJP responsibilities
* public service journey
* leadership vision

---

# C. Development Work Section

Showcases:

* roads
* drainage
* cleanliness
* public lighting
* infrastructure
* welfare activities

Each item includes:

* images
* descriptions
* location
* before/after visuals

---

# D. Achievements Section

Modern stat cards:

* completed works
* welfare programs
* public campaigns
* citizen engagement

---

# E. Public Feedback Section (Single Page Home)

# MAIN FEATURE MODULE

This is the core public engagement section on the main scrolling landing page.

Displays:

```text id="1jlwmw"
- Feedback Carousel (displaying ONLY featured citizen feedback reviews)
- CTA Link Button (prominent saffron button redirecting users to the detailed feedback page)
```

## Feedback Card Features (Home Carousel)

* citizen name
* area
* review message
* rating (1-5 stars)
* optional user avatar (uploaded/managed exclusively from the admin side; only featured feedbacks show this image)
* featured feedback flag

## Layout & Display

* **Listing Density:** The carousel listing must display multiple featured cards together on larger screens (e.g. 3 cards per slide/grid on desktop) to allow visitors to read more reviews at once.
* **No Quick Form:** The quick inline feedback form is entirely removed from the homepage.

---

# F. Detailed Feedback Page (Separate Page)

# SHAREABLE FEEDBACK MODULE

A separate, standalone page that can be shared as a link to different people to gather detailed feedback. It acts as both the submission portal and the public log of approved entries.

## Page Layout & Priorities

1. **Detailed Feedback Form (Primary Focus):** Positioned at the top of the page (first priority for user's attention). Allows submitting:
   * Full Name (required)
   * Mobile Number (required)
   * Area (required)
   * Feedback Title (required)
   * Feedback Message (required)
   * Rating (1-5 stars; required)
   * Photo Capture/Upload (optional; supports mobile camera capture)
2. **Approved Feedbacks Listing (Secondary Focus):** Positioned below the form (second priority). Displays a grid or list of all approved feedback entries (excluding their contact phone numbers for privacy).

---

# Workflow

```text id="4jlwmc"
submitted (from either single page form or separate detailed page)
→ pending review
→ approved/rejected
```

Only approved feedback becomes public.

---

# G. Gallery Section

Contains:

* ward visits
* BJP events
* development work
* public interactions
* community programs

---

# H. Contact Section

Contains:

* office details
* contact information
* social links
* office timings

Optional:

* Google Maps integration

---

# 12. Backend/Admin Panel

# Purpose

The backend is primarily used for:

```text id="3jlwm0"
content management
+
feedback approval management
```

---

# Admin Panel Style

Use:

* Tailwind CSS + daisyUI (for entire site, including admin panel with sidebar)
* Blade templating for all project view files
* fixed sidebar
* clean dashboard
* responsive tables

---

# Sidebar Menu

```text id="9jlwm6"
Dashboard
Feedback Management
Approved Reviews
Development Works
Gallery
CMS
Exports
Settings
Profile
Logout
```

---

# 13. Main Backend Modules

# A. Feedback Management Module

# MOST IMPORTANT ADMIN FEATURE

Admin can:

* view feedback
* approve
* reject
* feature review
* delete review

---

# Feedback Visibility Rule

```text id="5jlwmz"
Only approved feedback
should appear on frontend.
```

---

# B. CMS Module

Manage:

* hero content
* about section
* achievements
* contact details
* multilingual text content
* homepage sections

---

# C. Export Module

Export approved feedback:

* CSV
* Excel

Filters:

* date
* area
* rating

---

# D. Gallery Management

Manage:

* images
* categories
* captions
* multilingual descriptions

---

# 14. Authentication Module

No public registration.

Users created:

* via seeder only
* admin-managed

---

# Features

* login
* forgot password
* reset password
* remember me
* secure sessions

---

# 15. Technical Stack

# Backend

```text id="7jlwmz"
Laravel 13
```

---

# Local Environment

```text id="dir84env"
direnv setup to fix PHP version to php8.4 in this project directory
```

---

# Frontend & Views

```text id="5jlwmr"
Blade Templating + Vite + Tailwind CSS + daisyUI (unified design system across entire site)
```

---

# Database

```text id="6jlwmm"
MySQL
```

---

# UI Enhancements

Optional:

* Alpine.js
* AOS animations

---

# 16. Database Planning

# Core Tables

```text id="7jlwm4"
users
feedbacks
feedback_images
development_works
gallery_images
cms_pages
settings
password_reset_tokens
```

---

# Multilingual Fields Example

```text id="4jlwmv"
title_en
title_gu
title_hi

description_en
description_gu
description_hi
```

---

# 17. Security Planning

Must include:

* CSRF protection
* XSS sanitization
* upload validation
* login throttling
* rate limiting
* spam prevention

---

# 18. SEO & Performance

# SEO

Implement:

* multilingual SEO
* hreflang tags
* Open Graph
* sitemap
* schema markup

---

# Performance

Use:

* WebP images
* lazy loading
* optimized assets

Target:

```text id="1jlwm9"
90+ Lighthouse score
```

---

# 19. Mobile-First Requirement

The website must be:

```text id="5jlwm3"
fully mobile optimized
```

because majority public users:

* use Android devices
* use mobile internet
* access via social sharing links

---

# 20. Final Product Vision

The final product should feel like:

```text id="8jlwm2"
A premium multilingual civic leadership website
for Sachin Khandelwal,
focused on development,
public engagement,
transparency,
and trust-building
for the citizens of Vadodara Ward No. 7.
```

NOT:

```text id="9jlwmf"
a traditional political campaign website
```

---

# 21. AJAX-Based Pagination Requirement

The pagination across the system must be dynamic and AJAX-based to enhance user experience without full page reloads:

* **Detailed Feedback Page:** The list of approved testimonials shown under the feedback form must load pages asynchronously via AJAX when pagination links are clicked.
* **Admin Dashboard:** The administrative list/table of citizen feedback must load pagination results asynchronously via AJAX for smooth backend management.
