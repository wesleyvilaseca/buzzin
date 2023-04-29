<template>
    <div class="p-2" v-if="!isInCheckout">
        <div class="d-flex justify-content-between">
            <div class="cep">
                <ShippingValueCartComponent />
            </div>
            <div class="text-right">
                <div class="cart-price text-red">
                    Preço Total: <b>{{ moneyMask(subtotal) }}</b>
                </div>
            </div>
        </div>

        <div class="mt-4" v-if="!isInCheckout">
            <a href="" class="cart-finalizar" @click.prevent="openModalCheckout(true)">{{ textButton }}</a>
        </div>
    </div>

    <div v-else>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" :class="[step == 0 ? 'collapsed' : '']" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseOne" :aria-expanded="[step == 0 ? 'true' : '']"
                        aria-controls="collapseOne" @click.prevent="setStep(0)">
                        Selecione o endereço de entrega
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" :class="[step == 0 ? 'show' : '']"
                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <AddressStepComponent />
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button" :class="[step == 1 ? 'collapsed' : '']" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" :aria-expanded="[step == 1 ? 'true' : '']"
                        aria-controls="collapseTwo" :disabled="selectedAddress.zip_code == ''" @click.prevent="setStep(1)">
                        Selecione a forma de entrega
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" :class="[step == 1 ? 'show' : '']"
                    aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ShippingStepMethodsComponent />
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-controls="collapseThree"
                        :aria-expanded="[step == 2 ? 'true' : '']"
                        :disabled="selectedAddress.zip_code == '' || selectedShippingMethod.price == ''"
                        @click.prevent="setStep(2)">
                        Selecione a forma de pagamento
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" :class="[step == 2 ? 'show' : '']"
                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <PaymentStepComponent />
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-controls="collapseFour"
                        :aria-expanded="[step == 3 ? 'true' : '']" :disabled="selectedPaymentMethod.description == ''"
                        @click.prevent="setStep(3)">
                        Resumo do pedido
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" :class="[step == 3 ? 'show' : '']"
                    aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <ResumeOrderStepComponent />
                    </div>
                </div>
            </div>

            <div class="accordion-item" v-if="step == 4 && selectedPaymentMethod.integration"
                @click.prevent="setStep(4)">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFive" aria-controls="collapseFive"
                        :aria-expanded="[step == 4 ? 'true' : '']" :disabled="!selectedPaymentMethod.integration"
                        @click.prevent="setStep(4)">
                        Pagamento integração {{ selectedPaymentMethod.description }}
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" :class="[step == 4 ? 'show' : '']"
                    aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <IntegrationPaymentStep />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <ModalComponent v-show="isModalStoreIsClosed" title="Estabelecimento fechada" @close="openModalStoreIsClose(false)">
        <template v-slot:content>
            <div name="checkout-order" :heigth="350">
                <div class="alert alert-warning text-center">
                    Nesse momento estamos <strong>fechado</strong> :(
                </div>
            </div>
        </template>
    </ModalComponent>

    <ModalComponent v-show="isModalVisible" title="Pedido" @close="openModalCheckout(false)">
        <template v-slot:content>
            <div name="checkout-order" :heigth="350">
                <div class="px-md-5 my-4">
                    <div class="col-12" v-if="me.name == ''">
                        <div class="">
                            <div class="alert alert-warning text-center">
                                Para finalizar o pedido você precisa estar logado
                            </div>
                            <p><strong>Total de produtos: </strong>{{ products.length }}</p>
                            <p><strong>Preço total: </strong> {{ moneyMask(total) }}</p>
                            <div class="text-center d-grid gap-2 d-md-block">
                                <a href="/app/login" type="button" class="btn load_more_btn" style="width: 200px;">
                                    Login
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </ModalComponent>
</template>

<style scoped>
.load_more_btn {
    background: v-bind("paleta.btn_color") !important;
    color: v-bind("paleta.btn_color_letter") !important;
    border-radius: 25px !important;
}

.calcel-button {
    background: v-bind("paleta.btn_color_hover") !important;
    color: v-bind("paleta.btn_color_letter") !important;
    border-radius: 25px !important;
}

.load_more_btn:hover {
    background: v-bind("paleta.btn_color_hover") !important;
}
</style>
  
<script>
import ModalComponent from "../../../../components/widgets/ModalComponent.vue";
import AddressStepComponent from "./steps.checkout/address.vue";
import ShippingStepMethodsComponent from './steps.checkout/shippingMethod.vue';
import ShippingValueCartComponent from './components/shippingValueCart.vue';
import PaymentStepComponent from './steps.checkout/paymentMethod.vue';
import ResumeOrderStepComponent from './steps.checkout/resumeOrder.vue';
import IntegrationPaymentStep from "./steps.checkout/integrationPaymentStep.vue";
import { mapState, mapActions, mapMutations } from "vuex";

export default {
    components: {
        ModalComponent,
        AddressStepComponent,
        ShippingStepMethodsComponent,
        ShippingValueCartComponent,
        PaymentStepComponent,
        ResumeOrderStepComponent,
        IntegrationPaymentStep
    },
    data() {
        return {
            textButton: "Checkout",
            showBoxComment: false,
            comment: "",
            isModalVisible: false,
            isModalStoreIsClosed: false,
            disabledCart: false
        };
    },
    computed: {
        ...mapState({
            step: (state) => state.cart.step,
            products: (state) => state.cart.products.data,
            total: (state) => state.cart.total,
            subtotal: (state) => state.cart.subtotal,
            company: (state) => state.tenant.company,
            me: (state) => state.auth.me,
            address: (state) => state.auth.address,
            paleta: (state) => state.layout.paleta,
            selectedAddress: (state) => state.cart.selectedAddress,
            shippingMethods: (state) => state.cart.shippingMethods,
            selectedShippingMethod: (state) => state.cart.selectedShippingMethod,
            isInCheckout: (state) => state.cart.isInCheckout,
            paymentMethods: (state) => state.cart.paymentMethods,
            selectedPaymentMethod: (state) => state.cart.selectedPaymentMethod,
            troco: (state) => state.cart.troco,
            precisa_troco: (state) => state.cart.precisa_troco,
        }),

        totalOrder: function () {
            return this.total = this.total + this.selectedShippingMethod.price;
        },
    },
    methods: {
        ...mapActions(["getClientAddress"]),
        ...mapMutations({
            setInCheckout: "SET_IS_IN_CHECKOUT",
            clearCart: "CLEAR_CART",
            setStep: "SET_STEP"
        }),

        openModalCheckout(state) {
            if (this.company.isOpen === 'N' && this.company.clientCanBuy === 'N') {
                return this.openModalStoreIsClose(true);
            }

            if (this.me.name !== '') {
                this.setInCheckout(true);
                return this.getClientAddress();
            }

            this.isModalVisible = state;
        },

        openModalStoreIsClose(state) {
            this.isModalStoreIsClosed = state
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
    watch: {},
};
</script>