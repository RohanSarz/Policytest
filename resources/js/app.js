import "./bootstrap";
import "../css/app.css";
import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/vue3";

import Layout from "./Layouts/Layout.vue";
import FlashMesg from "./Pertials/FlashMesg.vue";
import { ZiggyVue, route } from "../../vendor/tightenco/ziggy/src/js";

createInertiaApp({
    title: (title) => `Teachlabs > ${title} `,
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        let page = pages[`./Pages/${name}.vue`];
        page.default.layout = page.default.layout || Layout;
        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)

            .component("Head", Head)
            .component("Link", Link)
            .component("FlashMesg", FlashMesg)
            .mount(el);
    },
    progress: false,
});
