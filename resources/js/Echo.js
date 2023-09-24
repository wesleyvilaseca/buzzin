
import { toast } from 'vue3-toastify';

// get id tenant
const tenantId = window?.Laravel?.tenantId;


window.Echo.channel(`buzzin_database_private-order-created.${tenantId}`)
.listen('OrderCreated', (e) => {
    toast.success(`Novo pedido ${e.order.identify}`, { autoClose: 9000 });
});