require('./bootstrap');
import { createApp } from 'vue';

import store from './store';

import VueTheMask from 'vue-the-mask';
import money from 'v-money3'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import Select2 from 'vue3-select2-component';

import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import preloader from './components/common/PreloaderComponent.vue';


/**
 * components admin
 */
import ordersAdminView from './views/admin/orders/orders.view.vue';
import subscriptionAdminView from './views/admin/subscriptions/subscriptions.view.vue';
import supportTenantView from './views/admin/tickets/tenant/support.view.vue';
import supportTicketView from './views/admin/tickets/support/support.view.vue';
import ticketConversationClient from './views/admin/tickets/tenant/conversation.view.vue';
import ticketConversationSupport from './views/admin/tickets/support/conversation.view.vue';


/**
 * components tenantwebsite
 */
import homeSiteTenantView from './views/tenant_site/home/home.view.vue';
import cartSiteTenantView from './views/tenant_site/cart/cart.view.vue';
import loginSiteTenantView from './views/tenant_site/login/login.view.vue';
import registerSiteTenantView from './views/tenant_site/register/register.view.vue';
import recoverSiteTenantView from './views/tenant_site/recover/recover.view.vue';
import resetPasswordSiteTenantView from './views/tenant_site/password_reset/password_reset.view.vue';
import checkoutSiteTenantView from './views/tenant_site/checkout/checkout.view.vue';
import maintenceSiteTenantView from './views/tenant_site/maintence/maintence.view.vue';
import ClientSiteTenantView from './views/tenant_site/client/index.view.vue';

var app = createApp();

/**
 * widgets components
 */
app.component('Select2', Select2)
app.component('Pagination', Bootstrap5Pagination);
app.component('preloader-component', preloader);

/**
 * admin components
 */
app.component('orders-tenant', ordersAdminView);
app.component('subscription-tenant', subscriptionAdminView);
app.component('support-tenant', supportTenantView);
app.component('support-tickets', supportTicketView);
app.component('ticket-conversation-tenant', ticketConversationClient);
app.component('ticket-conversation-support', ticketConversationSupport);


/**
 * view components website
 */
app.component('home-client-view', homeSiteTenantView);
app.component('cart-tenant-view', cartSiteTenantView);
app.component('login-tenant-view', loginSiteTenantView);
app.component('register-tenant-view', registerSiteTenantView);
app.component('recover-tenant-view', recoverSiteTenantView);
app.component('passord-reset-tenant-view', resetPasswordSiteTenantView);

app.component('checkout-tenant-view', checkoutSiteTenantView);
app.component('maintence-sitetenant-view', maintenceSiteTenantView);
app.component('client-tenant-view', ClientSiteTenantView);

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