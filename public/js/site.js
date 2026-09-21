/* =========================================
   SHARED SITE SCRIPT

   Navigation behaviour used by every public
   page: the scrolled state on the floating nav
   and the mobile drawer.
========================================= */

(function () {

    /* =========================================
       NAVIGATION SCROLL
    ========================================= */

    const nav = document.getElementById("nav");

    if (nav) {

        const setScrolled = () => {

            nav.classList.toggle("scrolled", window.scrollY > 40);

        };

        setScrolled();

        window.addEventListener("scroll", setScrolled);

    }


    /* =========================================
       MOBILE MENU
    ========================================= */

    const menuButton = document.getElementById("menuButton");
    const mobileMenu = document.getElementById("mobileMenu");

    if (!menuButton || !mobileMenu) {
        return;
    }

    const setOpen = (open) => {

        document.body.classList.toggle("menu-open", open);

        menuButton.setAttribute("aria-expanded", open ? "true" : "false");
        menuButton.textContent = open ? "✕" : "☰";

    };

    menuButton.addEventListener("click", () => {

        setOpen(!document.body.classList.contains("menu-open"));

    });

    // Tapping a link should close the drawer, including for same-page anchors
    // where no navigation happens.
    mobileMenu.addEventListener("click", (event) => {

        if (event.target.closest("a")) {
            setOpen(false);
        }

    });

    document.addEventListener("keydown", (event) => {

        if (event.key === "Escape") {
            setOpen(false);
        }

    });

    // The drawer is desktop-hidden by CSS; make sure the body lock goes with it.
    window.addEventListener("resize", () => {

        if (window.innerWidth > 900) {
            setOpen(false);
        }

    });

})();
