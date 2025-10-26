import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";

import Layout from "./Layouts/Layout.vue";
import FlashMesg from "./Pertials/FlashMesg.vue";
import { ZiggyVue, route } from "../../vendor/tightenco/ziggy/src/js";

// Import AOS and its CSS
import AOS from "aos";
import "aos/dist/aos.css";

createInertiaApp({
    title: (title) => `Teachlabs > ${title} `,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component("Head", Head)
            .component("Link", Link)
            .component("FlashMesg", FlashMesg)
            .mount(el);

        // Initialize AOS after the Vue app is mounted
        const items = document.querySelectorAll("[data-aos]");

        items.forEach((el, index) => {
            el.setAttribute("data-aos-delay", index * 200); // 100ms stagger
            el.setAttribute("data-aos-duration", 800); // optional: control speed
        });

        AOS.init({
            once: false, // run the animation only once
            easing: "ease-out-cubic", // looks smoother
        });


    },
    progress: true,
});
