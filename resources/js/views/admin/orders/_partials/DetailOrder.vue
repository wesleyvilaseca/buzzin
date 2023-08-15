<template>
    <div id="exampleModalLive" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
        :style="{ display: display }">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel">Detalhes do Pedido {{ order.identify }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="closeDetails"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" class="form form-inline" @submit.prevent="updateStatus">
                        <div class="row">
                            <div class="col-md-7">
                                <label for="status">Status:</label>
                                <select name="status" class="form-control form-control-sm" v-model="status">
                                    <option value="open">Aberto</option>
                                    <option value="done">Completo</option>
                                    <option value="rejected">Rejeitado</option>
                                    <option value="working">Andamento</option>
                                    <option value="canceled">Cancelado</option>
                                    <option value="delivering">Em transito</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <button type="submit" class="btn btn-sm btn-info mt-4" :disabled="loading">
                                    Atualizar Status
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card mt-2">
                                <div class="card-header">
                                    Número do pedido: {{ order.identify }} <br>
                                    Data: {{ order.date_br }} <br>
                                    Status: {{ order.status_label }}
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Produto</th>
                                                    <th scope="col">Quantidade</th>
                                                    <th scope="col">Valor</th>
                                                    <th scope="col">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(product, index) in order.products" :key="index">
                                                    <td><img :src="product.image" :alt="product.title"
                                                            style="max-width: 50px;">
                                                    </td>
                                                    <td>{{ product.title }}</td>
                                                    <td>{{ product.qty }}</td>
                                                    <td>R$ {{ product.price }}</td>
                                                    <td>R$ {{ product.qty * product.price }}</td>
                                                </tr>
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" align="right">
                                                        <strong>Subtotal</strong>
                                                    </td>
                                                    <td> R$ {{ subtotal }}</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4" align="right">
                                                        <strong>
                                                            {{ order?.shipping_method?.description }}
                                                        </strong>
                                                    </td>
                                                    <td> R$ {{ order?.shipping_method?.price }}</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4" align="right">
                                                        <strong>
                                                            Total
                                                        </strong>
                                                    </td>
                                                    <td> R$ {{ order.total }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card mt-2">
                                <div class="card-header">Dados do cliente</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-5" style="font-size:0.8rem">
                                            Cliente: {{ order.client?.name }} <br>
                                            Email: {{ order.client?.email }} <br>
                                            Celular: {{ order.client_mobile_phone }} <br>
                                            CPF: {{ order.client_doc }}
                                        </div>
                                        <div class="col-md-7" v-if="order?.shipping_method?.description !== RETIRADA"
                                        style="font-size:0.8rem"
                                        >
                                            Endereço: {{ order.client_address?.address }} - nº: {{
                                                order.client_address?.number
                                            }}<br>
                                            Complemento: {{ order.client_address?.complement }} <br>
                                            Bairro: {{ order.client_address?.district }} <br>
                                            CEP: {{ order.client_address?.zip_code }} <br>
                                            {{ order.client_address?.city }} - {{ order.client_address?.state }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <ul>
                        <li>Número do pedido: {{ order.identify }}</li>
                        <li>Total: R$ {{ total }}</li>
                        <li>Status: {{ order.status_label }}</li>
                        <li>Data: {{ order.date_br }}</li>
                        <li>
                            Cliente:
                            <ul>
                                <li>Nome: {{ order.client.name }}</li>
                                <li>image: {{ order.image }}</li>
                                <li>uuid: {{ order.uuid }}</li>
                                <li>Contato: {{ order.client.contact }}</li>
                            </ul>
                        </li>
                        <li>Mesa: {{ order.table.name }}</li>
                        <li>
                            Produtos:
                            <ul>
                                <li v-for="(product, index) in order.products" :key="index">
                                    <img :src="product.image" :alt="product.title" style="max-width: 100px;">
                                    {{ product.title }}
                                </li>
                            </ul>
                        </li>
                    </ul> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        display: {
            required: true
        },
        order: {
            type: Object,
            required: true
        }
    },
    computed: {
        subtotal() {
            let total = 0;
            this.order?.products?.map((item, index) => {
                total += item.qty * item.price;
            });
            return total;
        },
        total() {
            return this.order.total.toLocaleString('pt-br', { minimumFractionDigits: 2 })
        }
    },
    data() {
        return {
            status: '',
            loading: false,
            RETIRADA: 'Retirada'
        }
    },
    methods: {
        closeDetails() {
            this.$emit('closeDetails')
        },
        updateStatus() {
            this.loading = true
            axios.patch('/api/v1/my-orders', {
                status: this.status,
                identify: this.order.identify
            })
                .then(response => this.$emit('statusUpdated'))
                .catch(error => alert('error'))
                .finally(() => this.loading = false)
        }
    },
    watch: {
        order() {
            this.status = this.order.status
        }
    },
}
</script>