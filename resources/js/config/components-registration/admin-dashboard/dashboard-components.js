import app from '../../../main';
import ordersAdminView from '../../../views/admin/orders/orders.view.vue';
import subscriptionAdminView from '../../../views/admin/subscriptions/subscriptions.view.vue';
import supportTenantView from '../../../views/admin/tickets/tenant/support.view.vue';
import supportTicketView from '../../../views/admin/tickets/support/support.view.vue';
import ticketConversationClient from '../../../views/admin/tickets/tenant/conversation.view.vue';
import ticketConversationSupport from '../../../views/admin/tickets/support/conversation.view.vue';

/**
 * admin components
 */
app.component('orders-tenant', ordersAdminView);
app.component('subscription-tenant', subscriptionAdminView);
app.component('support-tenant', supportTenantView);
app.component('support-tickets', supportTicketView);
app.component('ticket-conversation-tenant', ticketConversationClient);
app.component('ticket-conversation-support', ticketConversationSupport);