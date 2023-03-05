require('./bootstrap');
import { createApp } from 'vue';

import store from './store';

import VueTheMask from 'vue-the-mask';
import money from 'v-money3'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import Select2 from 'vue3-select2-component';

import { createVfm } from 'vue-final-modal'
import 'vue-final-modal/style.css'

import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import homeSiteTenantView from './views/tenant_site/home/home.view.vue';
import cartSiteTenantView from './views/tenant_site/cart/cart.view.vue';
import loginSiteTenantView from './views/tenant_site/login/login.view.vue';
import registerSiteTenantView from './views/tenant_site/register/register.view.vue';

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
app.component('cart-tenant-view', cartSiteTenantView);
app.component('login-tenant-view', loginSiteTenantView);
app.component('register-tenant-view', registerSiteTenantView);
app.component('maintence-sitetenant-view', maintenceSiteTenantView);

const vfm = createVfm()
app.use(vfm);
app.use(Vue3Toasity, { autoClose: 3000 });
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