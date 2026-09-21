/* =========================================
   ADMIN

   Sidebar drawer and the image preview on the
   post form.
========================================= */

(function () {

    /* =========================================
       SIDEBAR DRAWER
    ========================================= */

    const toggle = document.getElementById("navToggle");
    const scrim = document.getElementById("sidebarScrim");

    const setOpen = (open) => {

        document.body.classList.toggle("nav-open", open);

        if (toggle) {
            toggle.setAttribute("aria-expanded", open ? "true" : "false");
        }

    };

    if (toggle) {

        toggle.addEventListener("click", () => {
            setOpen(!document.body.classList.contains("nav-open"));
        });

    }

    if (scrim) {
        scrim.addEventListener("click", () => setOpen(false));
    }

    document.addEventListener("keydown", (event) => {

        if (event.key === "Escape") {
            setOpen(false);
        }

    });

    window.addEventListener("resize", () => {

        if (window.innerWidth > 980) {
            setOpen(false);
        }

    });


    /* =========================================
       IMAGE PREVIEW
    ========================================= */

    const input = document.getElementById("image");
    const preview = document.getElementById("imagePreview");

    if (input && preview) {

        input.addEventListener("change", () => {

            const file = input.files && input.files[0];

            if (!file) {
                return;
            }

            const url = URL.createObjectURL(file);
            const image = preview.querySelector("img") || preview.appendChild(document.createElement("img"));

            image.src = url;
            image.alt = file.name;

            preview.hidden = false;

            // Drop the old object URL once the browser has the new image.
            image.addEventListener("load", () => URL.revokeObjectURL(url), { once: true });

            // Picking a new file cancels a pending removal.
            const remove = document.getElementById("remove_image");

            if (remove) {
                remove.checked = false;
            }

        });

    }


    /* =========================================
       DESTRUCTIVE ACTIONS
    ========================================= */

    document.querySelectorAll("form[data-confirm]").forEach((form) => {

        form.addEventListener("submit", (event) => {

            if (!window.confirm(form.dataset.confirm)) {
                event.preventDefault();
            }

        });

    });

})();
