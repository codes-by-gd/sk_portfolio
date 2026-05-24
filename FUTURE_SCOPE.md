# Future Scope & Premium Civic Enhancements

*This document houses high-value features, optimizations, and interactive civic elements deferred from the initial launch phase to be prioritized in subsequent release cycles.*

---

## 🗺️ Index of Future Enhancements

1. [📷 Client-Side Camera WebP Compression](#-client-side-camera-webp-compression)
2. [⏳ Dynamic Municipal Project Timeline Tracker](#-dynamic-municipal-project-timeline-tracker)
3. [🗺️ Spatial Leaflet Civic Map Widget](#%EF%B8%8F-spatial-leaflet-civic-map-widget)
4. [🛡️ Citizens Grievance & Feedback Tracker Portal](#%EF%B8%8F-citizens-grievance--feedback-tracker-portal)
5. [🎨 Patriotic Accent Themes Customizer](#-patriotic-accent-themes-customizer)

---

## 📷 Client-Side Camera WebP Compression

* **Objective:** Maximize bandwidth efficiency and reduce form submission latency for citizens uploading high-resolution mobile photos from slow cellular networks (3G/4G/5G).
* **Technical Proposal:**
  * Intercept the file-selection event and camera snapshot callback inside `detailed-feedback.blade.php`.
  * Inject the selected file/captured stream into a hidden HTML5 `canvas` element.
  * Re-sample the image boundaries and convert the image representation to a high-quality WebP format using:
    ```javascript
    canvas.toDataURL('image/webp', 0.75);
    ```
  * Send the compressed WebP base64 string to the controller instead of the raw, heavy JPEG file.
  * **Fallback Plan:** Auto-detect WebP support; if the device browser is legacy or lacks WebP support, degrade gracefully to a JPEG representation at `0.75` quality.
* **Why defer?** Initial requirements are satisfied by standard base64/multipart uploads. Client-side canvas handling can be added in an optimization patch to target slow connections.

---

## ⏳ Dynamic Municipal Project Timeline Tracker

* **Objective:** Elevate visual transparency by demonstrating step-by-step progress on public works directly to ward members.
* **Technical Proposal:**
  * Utilize daisyUI v5's native `timeline` component layout inside a new sections container.
  * **Visual Schema:**
    ```html
    <ul class="timeline timeline-vertical lg:timeline-horizontal">
      <li>
        <div class="timeline-start">Planning</div>
        <div class="timeline-middle"><i class="fa-solid fa-circle-check text-success"></i></div>
        <div class="timeline-end bg-base-200 p-3 rounded-xl">Project designed & funded</div>
        <hr class="bg-success"/>
      </li>
      <li>
        <hr class="bg-success"/>
        <div class="timeline-start">Execution</div>
        <div class="timeline-middle"><i class="fa-solid fa-helmet-safety text-primary"></i></div>
        <div class="timeline-end bg-base-200 p-3 rounded-xl">Roadwork underway</div>
        <hr/>
      </li>
      <li>
        <hr/>
        <div class="timeline-start">Audit</div>
        <div class="timeline-middle"><i class="fa-solid fa-circle-question text-base-content/40"></i></div>
        <div class="timeline-end bg-base-200 p-3 rounded-xl">Final civic evaluation</div>
      </li>
    </ul>
    ```
* **Why defer?** Focus for Phase 1 is limited to static Before/After slide portfolios rather than dynamic state tracking of civic works.

---

## 🗺️ Spatial Leaflet Civic Map Widget

* **Objective:** Introduce a highly visual, self-contained interactive map representing the geographic reach of Sachin Khandelwal's developmental works.
* **Technical Proposal:**
  * Embed **Leaflet.js** (open-source, extremely lightweight library under 40KB, requiring zero third-party API keys or billing overhead).
  * Configure interactive pins across Ward 7 coordinates representing completed works.
  * When a citizen clicks a coordinate marker, open a customized Leaflet tooltip popup displaying the daisyUI `diff` Before/After slider of that project.
* **Why defer?** Leaflet requires initial coordinate mappings and custom responsive viewport styling, which fits better as an advanced feature in the secondary development cycle.

---

## 🛡️ Citizens Grievance & Feedback Tracker Portal

* **Objective:** Provide citizens with immediate status clarity on their feedback (Pending, Moderated, In-Progress, Resolved) to decrease office query overhead.
* **Technical Proposal:**
  * Construct a dedicated public query form where citizens submit their mobile numbers to search for their grievance records.
  * **Security & Privacy Rules:**
    * Omit all sensitive personal information (address, full mobile digits, last names) in results to preserve strict GDPR/privacy compliance.
    * Use masked initials and progress checklists:
      * **Step 1: Submitted** (Status: Pending)
      * **Step 2: Moderated** (Status: Approved/Investigating)
      * **Step 3: Action Taken** (Status: Resolved with official response)
* **Why defer?** High administrative overhead for tracking status values; to be implemented after feedback volume reaches significant levels.

---

## 🎨 Patriotic Accent Themes Customizer

* **Objective:** Allow the portal to transition gracefully between localized events and festive phases without refactoring styling files.
* **Technical Proposal:**
  * Expand daisyUI v5 theme support to map seasonal configurations (e.g. "Republic Day Mode", "Diwali Theme", "Standard Patriotic").
  * Use daisyUI's dynamic runtime theme switching to let citizens select their preferred visual environment, or trigger server-scheduled theme switches on specific calendar events.
* **Why defer?** The existing light and dark patriotic configurations (`patriotic-theme` and `patriotic-dark`) provide exceptional readability and brand representation for Phase 1.
