<template>
    <div>
        <div class="card-header">
            <form action="#" method="POST" class="form form-inline">
                <div class="row">
                    <div class="col-md-3">
                        <label for="status">Status:</label>
                        <select name="status" class="form-control" v-model="status" @change.prevent="getOrders()">
                            <option value="all">Todos</option>
                            <option value="open">Aberto</option>
                            <option value="done">Completo</option>
                            <option value="rejected">Rejeitados</option>
                            <option value="working">Andamento</option>
                            <option value="canceled">Cancelado</option>
                            <option value="delivering">Em transito</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="date">Data:</label>
                            <input type="date" class="form-control" v-model="dateFilter"  @change.prevent=" getOrders()">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Status entrega</th>
                        <th>Data</th>
                        <th>Detalhes</th>
                        <th width="270">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(order, index) in orders.data" :key="index">
                        <td>{{ order.identify }}</td>
                        <td v-if="order?.shipping_method?.description !== RETIRADA">{{ order.status_label }}</td>
                        <td v-else> <span class="alert alert-warning p-1">Retirada</span></td>
                        <td>{{ order.date_br }}</td>
                        <td>
                            <template v-if="order.payment_method.integration">
                                {{ order.payment_method.integration }} - {{ paymentTypeIntegration(order) }} <br />
                               <b>Status: {{ order.order_integration_transaction.status }}</b> 
                            </template>
                            <template v-else>
                                {{ order.payment_method.description }}
                            </template>
                        </td>
                        <td>
                            <a href="#" @click.prevent="openDetails(order)" class="btn btn-info btn-sm"><i
                                    class="fa-solid fa-eye"></i></a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-if="loadingOrders">Carregando seus pedidos</div>
            <div v-else-if="orders.data.length == 0">Nenhum Pedido</div>
        </div>

        <detail-order :order="order" :display="displayOrder" @closeDetails="closeDetails"
            @statusUpdated="statusUpdated"></detail-order>
    </div>
</template>

<script>

import Bus from '../../../bus'
import DetailOrder from './_partials/DetailOrder'
export default {
    created() { },
    mounted() {
        this.getOrders()
        // Bus.$on('order.created', (order) => {
        //     this.orders.data.unshift(order)
        // })
    },
    data() {
        return {
            RETIRADA: 'Retirada',
            orders: {
                data: []
            },
            loadingOrders: false,
            dateFilter: new Date().getFullYear()+'-'+("0"+(new Date().getMonth()+1)).slice(-2)+'-'+("0"+new Date().getDate()).slice(-2),
            status: 'all',
            order: {
                identify: "",
                total: "",
                status: "",
                status_label: "",
                date: "",
                date_br: "",
                company: {
                    name: "",
                    image: "",
                    uuid: "",
                    contact: "",
                },
                client: {
                    name: "",
                    email: ""
                },
                table: "",
                products: [],
                evaluations: []
            },
            displayOrder: 'none',
        }
    },
    computed: {
     
    },
    methods: {
        paymentTypeIntegration(order) {
            // console.log(order.order_integration_transaction)
            if(order.payment_method.integration) {
                switch (order.order_integration_transaction.payment_type_id) {
                    case 'ticket':
                        return 'Boleto'                
                    default:
                        return 'Cartão de crédito';
                }
            }
        },

        getOrders() {
            this.reset()
            this.loadingOrders = true
            axios.get('/api/v1/my-orders', {
                params: {
                    status: this.status,
                    date: this.dateFilter
                }
            })
                .then(response => this.orders = response.data)
                .catch(error => alert('error'))
                .finally(() => this.loadingOrders = false)
        },
        reset() {
            this.orders = { data: [] }
        },
        statusUpdated(params) {
            this.closeDetails()
            this.getOrders()
        },
        openDetails(order) {
            this.order = order;
            this.displayOrder = 'block'
        },
        closeDetails() {
            this.order = {
                identify: "",
                total: "",
                status: "",
                status_label: "",
                date: "",
                date_br: "",
                company: {
                    name: "",
                    image: "",
                    uuid: "",
                    contact: "",
                },
                client: {
                    name: "",
                    email: ""
                },
                table: "",
                products: [],
                evaluations: []
            },
                this.displayOrder = 'none'
        },
    },
    watch: {
        status() {
            return this.getOrders()
        },
        dateFilter() {
            return this.getOrders()
        }
    },
    components: {
        DetailOrder
    }
}
</script>