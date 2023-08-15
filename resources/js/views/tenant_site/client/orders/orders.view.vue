<template>
    <div class="container pt-5 pb-3">
        <div class="my-4">
            <h4 class="title-tenant">Meus Pedidos</h4>
        </div>
        <template v-if="orders.length > 0">
            <div class="my-orders my-4">
                <div class="my-table-header mb-4">
                    <div class="text-center"><b>Nª Pedido</b></div>
                    <div class="text-center"><b>Data</b></div>
                    <div class="text-center"><b>Valor Total</b></div>
                    <div class="text-center"><b>Detalhes</b></div>
                </div>

                <div class="my-table" v-for="(order, index) in orders">
                    <div class="text-center">{{ order.identify }}</div>
                    <div class="text-center">{{ order.date_br }}</div>
                    <div class="text-center">{{ moneyMask(order.total) }} </div>
                    <div class="text-center">
                        <button type="button" class="btn detail-button me-2"
                            @click.prevent="openDetails(order)">Detalhes
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <template v-else>
            <div class="alert alert-warning">
                Você ainda não fez pedido nessa loja :(
            </div>
        </template>

        <detail-order 
        :order="order" 
        :display="displayOrder"
         @closeDetails="closeDetails"
            @statusUpdated="statusUpdated"></detail-order>
    </div>
</template>

<style scoped>
.detail-button:hover {
    background: v-bind("paleta.btn_color_hover") !important;
}

.detail-button {
    background: v-bind("paleta.btn_color") !important;
    color: v-bind("paleta.btn_color_letter") !important;
    border-radius: 25px !important;
}
</style>

<script>
import { mapActions, mapState, mapMutations } from "vuex";
import DetailOrder from './_partials/DetailOrder'

export default {
    props: [],
    components: {
        DetailOrder
    },
    data: () => ({
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
    }),
    computed: {
        ...mapState({
            paleta: (state) => state.layout.paleta,
            orders: (state) => state.auth.orders.data
        })
    },
    mounted() {
        this.getOrders()
        .then(() => {
            let urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('identify')) {
                const index = this.orders.findIndex(object => {return object.identify == urlParams.get('identify')});
               this.openDetails(this.orders[index]);
            }
        });
    },
    methods: {
        ...mapMutations({
            clearCart: "CLEAR_CART",
            setPreloader: "SET_PRELOADER",
            setTextPreloader: "SET_TEXT_PRELOADER"
        }),
        ...mapActions([
            "getOrders"
        ]),
        openDetails(order) {
            this.order = order;
            this.displayOrder = 'block'
        },
        statusUpdated(params) {
            this.closeDetails()
            this.getOrders()
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
        moneyMask(value) {
            if (typeof value !== "number") {
                return value;
            }
            var formatter = new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
            return formatter.format(value);
        }
    },

}
</script>