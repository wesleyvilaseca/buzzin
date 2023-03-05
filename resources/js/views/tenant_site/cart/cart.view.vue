<template>
    <DefaultLayout>
        <template v-slot:content>
            <div class="card">
                <div class="shopping-cart pt-">
                    <div class="card-header text-light">
                        <span style="color:#4060ff">
                            <i class="fa fa-shopping-cart me-2" aria-hidden="true"></i>
                            Carrinho de Compras
                        </span>
                        <a class="btn bnt-sm btn-comprando" href="/">
                            Continuar Comprando
                        </a>
                        <div class="clearfix"></div>
                    </div>

                    <div class="container">
                        <div class="card-body">
                            <div class="row align-items-center" v-for="(product, index) in products" :key="index">
                                <div class="col-4 text-center">
                                    <div class="img-circle">
                                        <img class="img-responsive" :src="product.item.image" alt="prewiew" width="120"
                                            height="80" />
                                    </div>
                                </div>
                                <div class="col-8 text-left">
                                    <h4 class="product-name">
                                        <strong>{{ product.item.title }}</strong>
                                    </h4>
                                    <h5 class="h6">{{ product.item.description }}</h5>
                                    <div class="d-flex py-4 justify-content-between align-items-center">
                                        <div class="col-10 d-flex align-items-center p-0">
                                            <h6>
                                                <strong>R$ {{ product.item.price }}
                                                    <span class="text-muted">x</span></strong>
                                            </h6>
                                            <div class="quantity ml-4">
                                                <input type="button" value="+" class="plus"
                                                    @click.prevent="incrementQty(product.item)" />
                                                <input type="number" step="1" max="99" min="1" :value="product.qty"
                                                    title="Qty" class="qty" size="4" />
                                                <input type="button" value="-" class="minus"
                                                    @click.prevent="decrementQty(product.item)" />
                                            </div>
                                        </div>
                                        <div class="col-2 col-sm-2 col-md-2 text-right">
                                            <button type="button" class="btn btn-outline-danger btn-xs"
                                                @click.prevent="deleteFromCart(product.item)">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <Checkout />
                        </div>
                    </div>
                </div>
            </div>
        </template>

    </DefaultLayout>
</template>

<style scoped>
.card--flat:hover .card-image img {
    transform: none !important;
}
</style>

<script>
import DefaultLayout from '../../layouts/tenant_site/DefaultLayout.vue';
import Checkout from './_partials/checkout.vue';
import { mapState, mapActions } from "vuex";
import { toast } from 'vue3-toastify';

export default {
    props: [],
    components: {
        DefaultLayout,
        Checkout
    },
    data: () => ({}),
    computed: {
        ...mapState({
            products: (state) => state.cart.products.data,
            company: (state) => state.tenant.company,
        }),
    },
    mounted() { },
    methods: {
        ...mapActions([
            "incrementToCart",
            "decrementToCart",
            "removeFromCart"
        ]),

        incrementQty(product) {
            this.incrementToCart({ uuid: this.company.uuid, product: product })
        },

        decrementQty(product) {
            this.decrementToCart({ uuid: this.company.uuid, product: product });
        },

        deleteFromCart(product) {
            this.removeFromCart({ uuid: this.company.uuid, product: product })
                .then(() => {
                    toast.success("Produto removido ao carrinho", { autoClose: 2000 });
                })
        },

        load() {
        },
    }
}
</script>