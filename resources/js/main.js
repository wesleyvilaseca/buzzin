import { createApp } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3'

const app = createApp();

createInertiaApp({
    resolve: name => import(`./views/${name}`),
    setup({ el, App, props, plugin }) {
        app.use(plugin)
            .mount(el)
    },
});

export default app; 