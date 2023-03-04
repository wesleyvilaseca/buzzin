require('./bootstrap');
import { createApp } from 'vue';

import store from './store';

import VueTheMask from 'vue-the-mask';
import money from 'v-money3'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import Select2 from 'vue3-select2-component';

import homeSiteTenantView from './views/tenant_site/home/home.view.vue';
import maintenceSiteTenantView from './views/tenant_site/maintence/maintence.view.vue';

var app = createApp();

/**
 * widgets components
 */
app.component('Select2', Select2)
app.component('Pagination', Bootstrap5Pagination);

/**
 * view components
 */
app.component('home-client-view', homeSiteTenantView);
app.component('maintence-sitetenant-view', maintenceSiteTenantView);

app.use(store);
app.use(VueTheMask);
app.use(money, {
    masked: false,
    prefix: '',
    suffix: '',
    thousands: ',',
    decimal: '.',
    precision: 2,
    disableNegative: false,
    disabled: false,
    min: null,
    max: null,
    allowBlank: false,
    minimumNumberOfCharacters: 0,
});

app.mount('#app');