<template>
    <div class="p-2" v-if="!isInCheckout">
        <div class="d-flex justify-content-between">
            <div class="cep">
                <div class="form-group">
                    <input type="text" id="cep" class="form-control" v-model="cartCep"
                        placeholder="Informe o CEP de entrega" v-mask="'#####-###'" v-if="!selectedAddress.zip_code" />
                </div>
            </div>
            <div class="text-right">
                <div class="cart-price text-red">
                    Preço Total: <b>R$ {{ total }}</b>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-left" v-if="!selectedAddress.zip_code">
            <div class="">
                <template v-if="loading">
                    <i class="fas fa-spinner fa-spin"></i> Buscando...
                </template>

                <template v-else>
                    <div class="alert alert-danger mt-2" v-if="errorMessage">
                        {{ errorMessage }} :(
                    </div>

                    <template v-if="shippingMethods.data.length > 0">
                        <ul class="list-group list-group-flush mt-2">
                            <li class="list-group-item list-group-item-success"
                                v-for="(method, index) in shippingMethods.data" :key="index">
                                {{ method.description }} : <strong>R$ {{ method.price }}</strong>
                                <template v-if="method.estimation">
                                    <ul class="ps-2">
                                        <li>Bairro: <strong>{{ method.estimation.location }}</strong><br />
                                            <span>
                                                Tempo estimado: <strong>
                                                    de {{ method.estimation.time_ini }}
                                                    a {{ method.estimation.time_end }} {{ method.estimation.time_unid }}
                                                </strong>
                                            </span>
                                        </li>
                                    </ul>
                                </template>
                            </li>
                        </ul>
                        <template v-if="shippingMethods.data[index++]">
                            <hr>
                        </template>
                    </template>
                </template>
            </div>
        </div>

        <!-- <div class="">
            <div class="d-flex justify-content-center" v-if="canFinish">
                <button type="button" class="btn load_more_btn" @click.prevent="changeCheckoutInfos()">Alterar endereço de
                    entrega?</button>
            </div>

            <div class="mb-2" v-if="'canFinish'">
                <label for="exampleFormControlTextarea1" class="form-label">Deseja fazer algum comentário para o lojista?
                </label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="comment"></textarea>
            </div>
        </div> -->

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
                        <Address />
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
                        <!-- aqui é a listagem das formas de entrega -->
                        <template v-if="shippingMethods.data.length > 0">
                            <div class="mt-3">
                                <div class="form-check" v-for="(method, index) in shippingMethods.data" :key="index">
                                    <input class="form-check-input" name="exampleRadios" type="radio" :id="`radio${index}`"
                                        @change.prevent="setShippingSelected(method)">
                                    <label class="form-check-label" :for="`radio${index}`">
                                        {{ method.description }} : <strong>R$ {{ method.price }}</strong>
                                        <br>
                                        <span v-if="method.estimation">
                                            Tempo estimado: <strong> de {{ method.estimation.time_ini }} a {{
                                                method.estimation.time_end }} {{ method.estimation.time_unid }}
                                            </strong>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </template>

                        <template v-else>
                            <div class="text-center mt-2">
                                <div class="alert alert-danger mt-2" v-if="errorMessage">
                                    {{ errorMessage }} :(
                                </div>
                            </div>
                        </template>

                        <template v-if="loading">
                            <div class="text-center mt-2">
                                <i class="fas fa-spinner fa-spin"></i> Buscando...
                            </div>
                        </template>
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
                        <template v-if="paymentMethods.data.length > 0">
                            <div class="mt-3">
                                <div class="form-check" v-for="(method, index) in paymentMethods.data" :key="index">
                                    <input class="form-check-input" name="paymentMethod" type="radio"
                                        :id="`radio${method.tag}`" @change.prevent="setPaymentMethodSelected(method)">
                                    <label class="form-check-label" :for="`radio${method.tag}`">
                                        {{ method.description }}
                                    </label>
                                </div>
                            </div>

                            <div class="mt-2 mb-2">
                                <label for="exampleFormControlTextarea1" class="form-label">Deseja fazer algum comentário
                                    para o lojista?
                                </label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                    v-model="comment"></textarea>
                            </div>
                        </template>
                        <template v-else>
                            <div class="alert alent-warning text-center">
                                Não há metodos de pagamento disponível
                            </div>
                        </template>

                        <template v-if="loading">
                            <div class="text-center mt-2">
                                <i class="fas fa-spinner fa-spin"></i> Buscando...
                            </div>
                        </template>

                        <template v-if="paymentSelected?.tag == 'pagar-em-dinheiro'">
                            <button type="button" class="btn load_more_btn mt-2" @click.prevent="openModalTroco(true)">
                                <span>Informar o troco</span>
                            </button>
                        </template>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Produto</th>
                                    <th scope="col">Quantidade</th>
                                    <th scope="col">Valor</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in products" :key="index">
                                    <td>{{ product.item.description }}</td>
                                    <td>R$ {{ product.item.price }}</td>
                                    <td>{{ product.qty }}</td>
                                    <td>R$ {{ product.qty * product.item.price }}</td>
                                </tr>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right">
                                        <strong>Subtotal</strong>
                                    </td>
                                    <td> R$ {{ total }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="text-right">
                                        <strong>
                                            {{ selectedShippingMethod.description }}
                                        </strong>
                                    </td>
                                    <td> R$ {{ selectedShippingMethod.price }}</td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="text-right">
                                        <strong>
                                            Total
                                        </strong>
                                    </td>
                                    <td> R$ {{ totalOrder }}</td>
                                </tr>

                                <tr>
                                    <td colspan="2">
                                        Forma de pagamento: {{ selectedPaymentMethod.description }}
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="2" v-if="selectedPaymentMethod.tag == 'pagar-em-dinheiro' && troco > 0">
                                        Troco para: R$ {{ troco }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="text-right mt-2">
                            <button class="btn btn-success btn-sm" @click.prevent="createOrder()">Finalizar pedido</button>
                        </div>
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
                            <p><strong>Preço total: </strong> R$ {{ total }}</p>
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

    <ModalComponent v-show="isModalTrocoVisible" :modalSize="'modal-lg'" title="Troco"
        @close="setPaymentMethodSelected(paymentSelected)">
        <template v-slot:content>
            <div name="checkout-order" :heigth="350">
                <div class="form-text text-danger" v-if="errors.troco != ''">
                    {{ errors.troco[0] || "" }}
                </div>
                <table class="table">
                    <tbody class="font-weight-normal">
                        <tr>
                            <td>Valor do pedido: </td>
                            <td>R$ {{ total }}</td>
                        </tr>
                        <tr>
                            <td>Valor do frete:</td>
                            <td>R$ {{ selectedShippingMethod.price }}</td>
                        </tr>

                        <tr>
                            <td>Valor total do pedido:</td>
                            <td>R$ {{ total + selectedShippingMethod.price }}</td>
                        </tr>
                    </tbody>
                </table>

                <div>
                    <label for="exampleInputEmail1" class="form-label">Precisa de troco?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1"
                            @change.prevent="setPrecisaDeTroco(true)">
                        <label class="form-check-label" for="inlineRadio1">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2"
                            @change.prevent="setPrecisaDeTroco(false)">
                        <label class="form-check-label" for="inlineRadio2">Não</label>
                    </div>
                </div>

                <div class="form-group mt-2" v-if="precisaTroco !== 'undefined' && precisaTroco == true">
                    <label>Troco pra quanto?</label>
                    <money3 v-model="troco" v-bind="config" class="form-control form-control-sm currency"
                        placeholder="50" />
                </div>

                <button type="button" class="btn load_more_btn mt-2"
                    @click.prevent="setPaymentMethodSelected(paymentSelected)" v-if="precisaTroco !== 'undefined'">
                    <span>Ok</span>
                </button>
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
import Address from "./steps.checkout/address.vue";
import { mapState, mapActions, mapMutations } from "vuex";
import { toast } from 'vue3-toastify';
import { Money3Component } from 'v-money3'

export default {
    components: {
        ModalComponent,
        money3: Money3Component,
        Address
    },
    data() {
        return {
            config: {
                masked: false,
                prefix: '',
                suffix: '',
                thousands: ',',
                decimal: '.',
                precision: 2,
                disableNegative: false,
                disabled: false,
                min: null,
                max: null,
                allowBlank: false,
                minimumNumberOfCharacters: 0,
            },
            modalTitle: "Checkout",
            textButton: "Checkout",
            showBoxComment: false,
            comment: "",
            troco: null,
            precisaTroco: "undefined",
            paymentSelected: {},
            cartCep: "",
            isModalVisible: false,
            isModalEnderecoVisible: false,
            isModalTrocoVisible: false,
            isModalStoreIsClosed: false,
            loading: false,
            errorMessage: "",
            disabledCart: false,
            errors: {
                troco: ""
            },
        };
    },
    computed: {
        ...mapState({
            step: (state) => state.cart.step,
            products: (state) => state.cart.products.data,
            total: (state) => state.cart.total,
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
        }),

        totalOrder: function () {
            return this.total = this.total + this.selectedShippingMethod.price;
        },
    },
    methods: {
        ...mapActions(["shippingValue", "getClientAddress", "getCepViaCep", "saveNewAddress", "sendCheckout", "getPaymentMethods"]),
        ...mapMutations({
            setSelectedAddress: "SET_SELECTED_ADDRESS",
            setShippingMethods: "SET_SHIPPING_METHODS",
            setSelectedShippingMethod: "SET_SELECTED_SHIPPING_METHOD",
            setShippingPriceToTotal: "SET_SHIPPING_VALUE_TO_TOTAL_CART",
            setInCheckout: "SET_IS_IN_CHECKOUT",
            setPaymentMethods: "SET_PAYMENT_METHODS",
            setSelectedPaymentMethod: "SET_SELECTED_PAYMENT_METHOD",
            clearCart: "CLEAR_CART",
            setStep: "SET_STEP"
        }),
        createOrder() {
            const params = {
                address: this.selectedAddress,
                products: this.products,
                shippingMethod: this.selectedShippingMethod,
                comment: this.comment,
                paymentMethod: this.selectedPaymentMethod,
                precisaTroco: this.precisaTroco ? "Y" : "N",
                troco: this.troco ? this.troco : 0
            }
            this.sendCheckout(params)
                .then((res) => {
                    this.clearCart(this.company.uuid);
                    toast.success("Pedido realizado com sucesso", { autoClose: 3000 });
                    window.location.href = `http://${this.company.subdomain}/app/cliente-area`;
                })
                .catch((error) => {
                    toast.error(
                        "Falha na operação, tente novamente",
                        { autoClose: 5000 }
                    );
                })
        },

        setShippingSelected(item) {
            this.setSelectedShippingMethod(item);
            this.setShippingPriceToTotal(this.selectedShippingMethod?.price);

            //clear payment methods
            this.setSelectedPaymentMethod({ description: "" });
            this.setPaymentMethods([]);

            if (this.selectedAddress.zip_code !== "" && this.selectedShippingMethod.price !== "") {
                this.loading = true
                this.getPaymentMethods({ selectedShippingMethod: this.selectedShippingMethod })
                    .catch((error) => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false)
                this.setStep(2)
            }
        },

        setPrecisaDeTroco(state) {
            this.precisaTroco = state;
        },

        setPaymentMethodSelected(item) {
            this.reset();
            this.paymentSelected = item;
            this.setSelectedPaymentMethod({ description: "" });

            if (this.paymentSelected.tag == "pagar-em-dinheiro") {
                if (this.precisaTroco == "undefined") {
                    return this.openModalTroco(true);
                }

                if (this.precisaTroco) {
                    this.setStep(2);
                    if (this.troco == null) {
                        this.errors.troco = ["Informa o valor para troco"];
                        this.openModalTroco(true);
                        return;
                    }

                    if (this.troco) {
                        if (this.troco < this.total) {
                            this.errors.troco = ["O valor do troco não deve ser menor que o valor total do pedido"]
                            this.openModalTroco(true);
                            return;
                        }
                    }
                }
            } else {
                this.precisaTroco = "undefined";
                var radio = document.querySelector('input[type=radio][name=inlineRadioOptions]:checked');
                if (radio) {
                    radio.checked = false;
                }
            }

            this.openModalTroco(false);
            this.setSelectedPaymentMethod(item);
            this.setStep(3);

        },

        backAddressList() {
            this.setSelectedAddress(this.formAddress);
            this.setShippingMethods({ data: [] });
            this.setSelectedShippingMethod({ price: "" });
        },
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
        modalEndereco(state) {
            this.resetForm();
            if (!state) {
                this.resetForm();
                this.reset();
            }
            return this.isModalEnderecoVisible = state;
        },

        openModalTroco(state) {
            this.isModalTrocoVisible = state;
        },

        openModalStoreIsClose(state) {
            this.isModalStoreIsClosed = state
        },

        changeCheckoutInfos() {
            this.isModalEnderecoVisible = true;
        },

        reset() {
            this.errors = { cpf: "", address: "", zip_code: "", state: "", city: "", district: "", number: "", complement: "", troco: "" }
        },
    },
    watch: {
        cartCep() {
            if (this.cartCep.length === 9) {
                this.errorMessage = "";
                this.loading = true;
                this.getShippingValue(this.cartCep)
                    .catch((error) => {
                        if (error?.response?.data?.message) {
                            this.errorMessage = error.response.data.message;
                        }
                    })
                    .finally(() => this.loading = false);
            }
        },

        shippingMethods() {
            if (this.selectedAddress.zip_code && this.shippingMethods.data.length <= 0) {
                this.errorMessage = "Não há metodos de entrega disponível"
            }
        }
    },
};
</script>