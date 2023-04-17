
import Bus from './bus'
import { toast } from 'vue3-toastify';

// get id tenant
const tenantId = window.Laravel.tenantId;

// window.Echo.channel(`buzzin_database_private-order-created.${tenantId}`)
// .listen('.App\\Events\\OrderCreated', (e) => {
//     Bus.$emit('order.created', e.order)
//     toast.success(`Novo pedido ${e.order.identify}`, { autoClose: 9000 });
// })


window.Echo.channel(`buzzin_database_private-product-created.${tenantId}`)
.listen('ProductCreated', (e) => {
    console.log('aqui');
    toast.success(`Novo produto criado ${e.product.title}`, { autoClose: 9000 });
})