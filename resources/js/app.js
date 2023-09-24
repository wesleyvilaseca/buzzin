require('./bootstrap');
import { createApp } from 'vue';
import store from './store';

import ordersAdminView from './views/admin/orders/orders.view.vue';
import subscriptionAdminView from './views/admin/subscriptions/subscriptions.view.vue';
import supportTenantView from './views/admin/tickets/tenant/support.view.vue';
import supportTicketView from './views/admin/tickets/support/support.view.vue';
import ticketConversationClient from './views/admin/tickets/tenant/conversation.view.vue';
import ticketConversationSupport from './views/admin/tickets/support/conversation.view.vue';

import Vue3Toasity from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import VueTheMask from 'vue-the-mask';
import money from 'v-money3'
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import Select2 from 'vue3-select2-component';

const app = createApp();

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
 * widgets components
 */
app.component('Select2', Select2)
app.component('Pagination', Bootstrap5Pagination);


app.use(Vue3Toasity, { autoClose: 3000 });
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

app.use(store);
app.mount('#app');