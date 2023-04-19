
import Bus from './bus'
import { toast } from 'vue3-toastify';

// get id tenant
const tenantId = window.Laravel.tenantId;

window.Echo.channel(`buzzin_database_presence-order-created.${tenantId}`)
.listen('OrderCreated', (e) => {
    Bus.$emit('order.created', e.order)
    toast.success(`Novo pedido ${e.order.identify}`, { autoClose: 9000 });
})


window.Echo.channel(`buzzin_database_presence-product-created.${tenantId}`)
.listen('ProductCreated', (e) => {
    console.log(e);
    // Bus.$emit('order.created', e.product);
    toast.success(`Novo produto criado ${e.product.title}`, { autoClose: 9000 });
})