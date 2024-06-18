require('./bootstrap');
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3'
import store from './store';
import { Link } from '@inertiajs/vue3'
import Vue3Toasity from 'vue3-toastify';
import VueTheMask from 'vue-the-mask';
import 'vue3-toastify/dist/index.css';
import { InertiaProgress } from '@inertiajs/progress';
import { route } from 'ziggy-js';

InertiaProgress.init({
    progress: {
        delay: 250,
        color: '#29d',
        includeCSS: true,
        showSpinner: false,
    }
});

createInertiaApp({
    resolve: name => import(`./views/${name}`),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .mixin({ methods: { route } })
            .use(plugin)
            .use(store)
            .use(Vue3Toasity, { autoClose: 3000 })
            .use(VueTheMask)
            .component('Link', Link)
            .mount(el)
    },
});