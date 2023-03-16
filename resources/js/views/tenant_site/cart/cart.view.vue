<template>
    <DefaultLayout>
        <template v-slot:content>
            <div class="container pt-4">
                <div class="shopping-cart pb-3" style="border-radius: 10px;">
                    <div class="card-header text-light">
                        <span>
                            <i class="fa fa-shopping-cart me-2" aria-hidden="true"></i>
                            Carrinho de Compras
                        </span>
                        <a class="btn bnt-sm btn-comprando" href="/">
                            Continuar Comprando
                        </a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="container">
                        <div class="">
                            <div class="text-center" v-if="showAlertDeliveryDate">
                                <div class="alert alert-warning">
                                    Nesse momento a loja está fechada
                                    <p v-if="selectedShippingMethod.description == 'Retirada'">
                                        Você poderá efetuar a <strong>retirada</strong> da sua compra quando estivermos
                                        aberto
                                    </p>
                                    <p v-else>
                                        A sua entrega será processados quando a loja estiver aberta
                                    </p>

                                    <p> Consulte nosso horário de funcionamento
                                        <a href="/"> <strong>aqui </strong></a>
                                        :)
                                    </p>
                                </div>
                            </div>

                            <div class="div">
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
                                                        @click.prevent="incrementQty(product.item)"
                                                        :disabled="{ disabledProductButtons }" />
                                                    <input type="number" step="1" max="99" min="1" :value="product.qty"
                                                        title="Qty" class="qty" size="4" />
                                                    <input type="button" value="-" class="minus"
                                                        @click.prevent="decrementQty(product.item)"
                                                        :disabled="{ disabledProductButtons }" />
                                                </div>
                                            </div>

                                            <div class="col-2 col-sm-2 col-md-2 text-right" v-if="disabledProductButtons">
                                                <button type="button" class="btn btn-outline-danger btn-xs"
                                                    @click.prevent="deleteFromCart(product.item)">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                            <div class="col-2 col-sm-2 col-md-2 text-right" v-else>
                                                <strong> R$ {{ product.qty * product.item.price }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row align-items-center" v-if="selectedAddress.zip_code !== ''">
                                    <hr>
                                    <div class="title text-center">
                                        <h5>Endereço de entrega</h5>
                                    </div>
                                    <div class="col-4">
                                        <div class="">
                                            <h5 class="mb-1">{{ selectedAddress.address }}
                                                <span v-if="selectedAddress.number"> n: {{ selectedAddress.number
                                                }}</span>
                                                {{ selectedAddress.district }}
                                            </h5>
                                        </div>
                                        <p class="mb-1"> {{ selectedAddress.complement }} {{ selectedAddress.city }} -
                                            {{
                                                selectedAddress.state }}</p>
                                        <small class="text-muted">{{ selectedAddress.zip_code }}</small>
                                    </div>
                                    <div class="col-8 text-left">
                                        <h4 class="product-name">
                                            <strong></strong>
                                        </h4>
                                        <h5 class="h6"></h5>
                                        <div class="d-flex py-4 justify-content-between align-items-center">
                                            <div class="col-10 d-flex align-items-center p-0">
                                                <h6>
                                                    <strong></strong>
                                                </h6>
                                                <div class="quantity ml-4">
                                                </div>
                                            </div>
                                            <div class="col-2 col-sm-2 col-md-2 text-right">
                                                <strong v-if="selectedShippingMethod.price !== ''">
                                                    R$ {{ selectedShippingMethod.price }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <!-- <hr /> -->
                        </div>
                        <Checkout />
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

.shopping-cart .card-header span {
    color: v-bind("paleta.links");
}

.shopping-cart .card-header span:hover {
    color: v-bind("paleta.links_hover");
}

.shopping-cart .card-header .btn {
    background-color: v-bind("paleta.btn_color") !important;
    color: #fff !important;
}

.shopping-cart .card-header .btn:hover {
    background-color: v-bind("paleta.btn_color_hover") !important;
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
    data: () => ({
        showAlertDeliveryDate: false,
        disabledProductButtons: false
    }),
    computed: {
        ...mapState({
            products: (state) => state.cart.products.data,
            company: (state) => state.tenant.company,
            paleta: (state) => state.layout.paleta,
            checkout: (state) => state.cart.isInCheckout,
            selectedAddress: (state) => state.cart.selectedAddress,
            selectedShippingMethod: (state) => state.cart.selectedShippingMethod,
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
    },
    watch: {
        selectedShippingMethod() {

            if (this.selectedAddress.zip_code) {
                this.disabledProductButtons = true
            } else {
                this.disabledProductButtons = true
            }

            if (this.company.isOpen === 'N' && this.company.orderWhenClose === 'S' && this.selectedShippingMethod.price !== "") {
                this.showAlertDeliveryDate = true;
                return;
            }

            this.showAlertDeliveryDate = false;
        },

        selectedShippingMethod() {
            if (this.selectedAddress.zip_code && this.selectedShippingMethod.price !== "") {
                this.textButton = 'Finalizar pedido agora';
                this.showBoxComment = true;
                this.canFinish = true;
            } else {
                this.textButton = 'Checkout';
                this.showBoxComment = false;
                this.canFinish = false;
            }
        }
    },
}
</script>