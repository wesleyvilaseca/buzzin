require('./bootstrap');
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3'
import store from './store';
import { Link } from '@inertiajs/vue3'

createInertiaApp({
    resolve: name => import(`./views/${name}`),
    setup({ el, App, props, plugin }) {
            createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(store)
            .component('Link', Link)
            .mount(el)
    },
});