/* =========================================
   BLOG

   Read-more toggles, load-more pagination and
   the per-viewer like / save / share actions.

   Likes and saves are stored in this browser
   only — there is no backend for them.
========================================= */

(function () {

    const STORE_KEY = "blog-actions";


    /* =========================================
       LOCAL STATE
    ========================================= */

    const readStore = () => {

        try {
            return JSON.parse(localStorage.getItem(STORE_KEY)) || {};
        } catch (error) {
            return {};
        }

    };

    const writeStore = (state) => {

        try {
            localStorage.setItem(STORE_KEY, JSON.stringify(state));
        } catch (error) {
            // Private browsing or blocked storage — the toggle still works for
            // this page view, it just will not be remembered.
        }

    };

    const isOn = (postId, kind) => Boolean(readStore()[kind + ":" + postId]);

    const setOn = (postId, kind, on) => {

        const state = readStore();
        const key = kind + ":" + postId;

        if (on) {
            state[key] = true;
        } else {
            delete state[key];
        }

        writeStore(state);

    };


    /* =========================================
       ACTION BUTTONS
    ========================================= */

    const LABELS = {
        like: ["Like", "Liked"],
        save: ["Save", "Saved"],
    };

    const paint = (button, on) => {

        const kind = button.dataset.toggle;
        const label = button.querySelector("span");

        button.classList.toggle("is-on", on);
        button.setAttribute("aria-pressed", on ? "true" : "false");

        if (label && LABELS[kind]) {
            label.textContent = LABELS[kind][on ? 1 : 0];
        }

    };

    const hydrate = (root) => {

        root.querySelectorAll("[data-toggle]").forEach((button) => {

            const card = button.closest("[data-post]");

            if (!card || button.dataset.ready) {
                return;
            }

            button.dataset.ready = "1";
            paint(button, isOn(card.dataset.post, button.dataset.toggle));

        });

    };

    hydrate(document);


    /* =========================================
       EVENTS
    ========================================= */

    document.addEventListener("click", async (event) => {

        /* Read more ------------------------ */

        const readMore = event.target.closest("[data-read-more]");

        if (readMore) {

            const body = readMore.closest(".post-body");
            const excerpt = body.querySelector("[data-excerpt]");
            const full = body.querySelector("[data-full]");
            const expanded = full.hidden === false;

            excerpt.hidden = !expanded;
            full.hidden = expanded;
            readMore.textContent = expanded ? "Read more" : "Show less";

            return;

        }

        /* Like / save ---------------------- */

        const toggle = event.target.closest("[data-toggle]");

        if (toggle) {

            const card = toggle.closest("[data-post]");

            if (card) {

                const on = !toggle.classList.contains("is-on");

                setOn(card.dataset.post, toggle.dataset.toggle, on);
                paint(toggle, on);

            }

            return;

        }

        /* Share ---------------------------- */

        const share = event.target.closest("[data-share]");

        if (share) {

            const url = new URL(share.dataset.url, window.location.origin).href;
            const label = share.querySelector("span");

            if (navigator.share) {

                try {
                    await navigator.share({ title: share.dataset.title, url: url });
                } catch (error) {
                    // The viewer dismissed the share sheet.
                }

                return;

            }

            try {

                await navigator.clipboard.writeText(url);

                if (label) {

                    label.textContent = "Copied";
                    setTimeout(() => { label.textContent = "Share"; }, 1600);

                }

            } catch (error) {

                window.prompt("Copy this link:", url);

            }

            return;

        }

        /* Load more ------------------------ */

        const loadMore = event.target.closest("#loadMore");

        if (!loadMore) {
            return;
        }

        event.preventDefault();

        const feed = document.getElementById("feed");
        const next = loadMore.getAttribute("href");

        if (!feed || !next || loadMore.dataset.busy) {
            return;
        }

        loadMore.dataset.busy = "1";
        loadMore.textContent = "Loading…";

        try {

            const response = await fetch(next, { headers: { "X-Requested-With": "fetch" } });

            if (!response.ok) {
                throw new Error("Request failed");
            }

            const markup = await response.text();
            const parsed = new DOMParser().parseFromString(markup, "text/html");

            parsed.querySelectorAll("#feed .post-card").forEach((card) => {
                feed.appendChild(document.importNode(card, true));
            });

            hydrate(feed);

            const nextLink = parsed.querySelector("#loadMore");

            if (nextLink) {

                loadMore.setAttribute("href", nextLink.getAttribute("href"));
                loadMore.textContent = "Load more posts";
                delete loadMore.dataset.busy;

                // Keep the address bar in step with what is on screen.
                window.history.replaceState({}, "", next);

            } else {

                loadMore.replaceWith(
                    Object.assign(document.createElement("span"), {
                        className: "feed-end",
                        textContent: "You have reached the end",
                    })
                );

            }

        } catch (error) {

            // Fall back to a normal page load so the viewer is never stuck.
            window.location.href = next;

        }

    });

})();
