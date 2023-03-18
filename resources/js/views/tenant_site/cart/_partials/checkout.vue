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

        <div class="">
            <div class="d-flex justify-content-center" v-if="canFinish">
                <button type="button" class="btn load_more_btn" @click.prevent="changeCheckoutInfos()">Alterar endereço de
                    entrega?</button>
            </div>

            <div class="mb-2" v-if="canFinish">
                <label for="exampleFormControlTextarea1" class="form-label">Deseja fazer algum comentário para o lojista?
                </label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="comment"></textarea>
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
                    <button class="accordion-button" :class="{ 'collapsed': step.stepZero }" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseOne" :aria-expanded="{ 'true': step.stepZero }"
                        aria-controls="collapseOne"
                        @click.prevent="setStep({ stepZero: true, one: false, two: false, three: false, four: false })">
                        Selecione o endereço de entrega
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" :class="{ 'show': step.stepZero }"
                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn load_more_btn"
                                @click.prevent="modalEndereco(true)">Adicionar</button>
                        </div>

                        <div v-if="address.data.length > 0">
                            <div cla v-for="(item, index) in address.data" :key="index" @click.prevent="setAddress(item)"
                                class="card mt-1" style="cursor: pointer;">
                                <div class="card-body">
                                    <div>
                                        {{ item.address }}
                                        <span v-if="item.number">
                                            n: {{ item.number }}
                                        </span>
                                        {{ item.district }}
                                    </div>
                                    <!-- <small class="badge bg-success" v-if="item.status == 1">Endereço principal</small> -->
                                    <p class="mb-1"> {{ item.complement }} {{ item.city }} - {{ item.state }}</p>
                                    <small class="text-muted">{{ item.zip_code }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2" v-else>
                            <div class="alert alert-warning text-center"> Você não possuí endereços cadastrados </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button" :class="{ 'collapsed': step.one }" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" :aria-expanded="{ 'true': step.one }"
                        aria-controls="collapseTwo" :disabled="selectedAddress.zip_code == ''"
                        @click.prevent="setStep({ stepZero: false, one: true, two: false, three: false, four: false })">
                        Selecione a forma de entrega
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" :class="{ 'show': step.one }"
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

                        <template v-if="shippingMethods.data.length <= 0">
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
                        data-bs-target="#collapseThree" aria-controls="collapseThree" :aria-expanded="{ 'true': step.two }"
                        :disabled="selectedAddress.zip_code == '' || selectedShippingMethod.price == ''"
                        @click.prevent="setStep({ stepZero: false, one: false, two: true, three: false, four: false })">
                        Selecione a forma de pagamento
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" :class="{ 'show': step.two }"
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
                        data-bs-target="#collapseFour" aria-controls="collapseFour" :aria-expanded="{ 'true': step.three }"
                        :disabled="selectedPaymentMethod.description == ''"
                        @click.prevent="setStep({ stepZero: false, one: false, two: false, three: true, four: false })">
                        Resumo do pedido
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" :class="{ 'show': step.three }"
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

    <ModalComponent v-show="isModalEnderecoVisible" title="Cadastrar novo endereço" @close="modalEndereco(false)">
        <template v-slot:content>
            <template v-if="company.isOpen == 'N'">
                <div class="text-center">
                    <div class="alert alert-warning">
                        Nesse momento a loja está fechada
                        <p>
                            Entregas e retiradas serão feitas quando a loja estiver aberta
                        </p>
                    </div>
                </div>
            </template>

            <div name="checkout-order" :heigth="350" v-if="company.clientCanBuy == 'Y'">
                <!-- caso ele esteja na página de listagem de endereços -->
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn calcel-button me-2"
                        @click.prevent="modalEndereco(false)">Cancelar</button>
                    <button type="button" class="btn load_more_btn" @click.prevent="salveAddress()" :disabled="loading">
                        <span v-if="loading">Salvando...</span>
                        <span v-else> Salvar</span>
                    </button>
                </div>

                <form>
                    <div class="row">
                        <div class="form-group mt-2 col-md-4">
                            <label>CEP:</label>
                            <input type="text" v-model="formAddress.zip_code" class="form-control form-control-sm"
                                placeholder="CEP:" @blur.prevent="buscacep()" v-mask="'#####-###'">
                            <div class="form-text text-danger" v-if="errors.zip_code != ''">
                                {{ errors.zip_code[0] || "" }}
                            </div>
                        </div>

                        <div class="form-group mt-2 col-md-5">
                            <label>Cidade: *</label>
                            <input type="text" v-model="formAddress.city" class="form-control form-control-sm"
                                placeholder="Cidade:" readonly>
                            <div class="form-text text-danger" v-if="errors.city != ''">
                                {{ errors.city[0] || "" }}
                            </div>
                        </div>

                        <div class="form-group mt-2 col-md-2">

                            <label>UF: *</label>
                            <input type="text" v-model="formAddress.state" class="form-control form-control-sm"
                                placeholder="UF:" readonly>
                            <div class="form-text text-danger" v-if="errors.state != ''">
                                {{ errors.state[0] || "" }}
                            </div>
                        </div>

                        <div class="form-group mt-2 col-md-5">

                            <label>Bairro: *</label>
                            <input type="text" v-model="formAddress.district" class="form-control form-control-sm"
                                placeholder="Bairro:" readonly>
                            <div class="form-text text-danger" v-if="errors.district != ''">
                                {{ errors.district[0] || "" }}
                            </div>
                        </div>

                        <div class="form-group mt-2 col-md-5">
                            <label>Endereço: *</label>
                            <input type="text" v-model="formAddress.address" class="form-control form-control-sm"
                                placeholder="Endereço:">
                            <div class="form-text text-danger" vv-if="errors.address != ''">
                                {{ errors.address[0] || "" }}
                            </div>
                        </div>

                        <div class="form-group mt-2 col-md-2">
                            <label>Numero:</label>
                            <input type="text" v-model="formAddress.number" class="form-control form-control-sm">
                            <div class="form-text text-danger" v-if="errors.number != ''">
                                {{ errors.number[0] || "" }}
                            </div>
                        </div>

                        <div class="form-group mt-2 col-md-12">
                            <label>Complemento:</label>
                            <input type="text" v-model="formAddress.complement" class="form-control form-control-sm"
                                placeholder="Complemento:">
                            <div class="form-text text-danger" v-if="errors.complement != ''">
                                {{ errors.complement[0] || "" }}
                            </div>
                        </div>
                    </div>
                </form>
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
import { mapState, mapActions, mapMutations } from "vuex";
import { toast } from 'vue3-toastify';
import { Money3Component } from 'v-money3'

export default {
    components: {
        ModalComponent,
        money3: Money3Component
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
            step: {
                stepZero: true,
                one: false,
                two: false,
                three: false,
                four: false,
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
            loading: false,
            errorMessage: "",
            disabledCart: false,
            canSaveAdrdess: false,
            canFinish: false,
            formAddress: {
                address: "",
                zip_code: "",
                state: "",
                city: "",
                district: "",
                number: "",
                complement: "",
                id: ""
            },
            errors: {
                address: "",
                zip_code: "",
                state: "",
                city: "",
                district: "",
                number: "",
                complement: "",
                troco: ""
            },
        };
    },
    computed: {
        ...mapState({
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
            setSelectedPaymentMethod: "SET_SELECTED_PAYMENT_METHOD"
        }),
        createOrder() {
            const params = {
                address: this.selectedAddress,
                products: this.products,
                shippingMethod: this.selectedShippingMethod,
                comment: this.comment
            }
            this.sendCheckout(params)
                .then((res) => {
                    console.log(res);
                })
                .catch((error) => {
                    console.log(error);
                })
        },

        setAddress(item) {
            this.loading = true;
            this.setSelectedAddress(item);

            //clear shipping methods
            this.setShippingMethods({ data: [] })
            this.setSelectedShippingMethod({ price: "" });

            //clear payment methods
            this.setSelectedPaymentMethod({ description: "" });
            this.setPaymentMethods([]);

            this.getShippingValue(item.zip_code)
                .catch((error) => {
                    if (error?.response?.data?.message) {
                        this.errorMessage = error.response.data.message;
                    }
                })
                .finally(() => {
                    this.loading = false
                });

            this.setStep({ stepZero: false, one: true, two: false, three: false, four: false })
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
                this.setStep({ stepZero: false, one: false, two: true, three: false, four: false })
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
                    console.log('aqui')
                    this.setStep({ stepZero: false, one: false, two: true, three: false, four: false });
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
            this.setStep({ stepZero: false, one: false, two: false, three: true, four: false });

        },

        backAddressList() {
            this.setSelectedAddress(this.formAddress);
            this.setShippingMethods({ data: [] });
            this.setSelectedShippingMethod({ price: "" });
        },
        openModalCheckout(state) {
            // if (this.canFinish) {
            //     this.createOrder();
            //     return;
            // }

            if (this.me.name !== '') {
                this.setInCheckout(true);
                this.getClientAddress();
                return;
                // this.modalEndereco(true);
                // return;
            }


            this.isModalVisible = state;
        },
        modalEndereco(state) {
            this.resetForm();
            // if (!this.selectedAddress.zip_code && this.shippingMethods.data.length > 0 && state) {
            //     this.setShippingMethods({ data: [] })
            // }
            if (!state) {
                this.resetForm();
                this.reset();
            }
            return this.isModalEnderecoVisible = state;
        },

        openModalTroco(state) {
            this.isModalTrocoVisible = state;
        },

        changeCheckoutInfos() {
            this.isModalEnderecoVisible = true;
        },

        // showForm(state) {
        //     this.showFormAddress = state
        // },

        salveAddress() {
            this.reset();
            this.validateForm();
            if (!this.canSaveAddress) return;

            this.loading = true;

            this.saveNewAddress(this.formAddress)
                .then((res) => {
                    // this.showFormAddress = false
                    toast.success("Endereço salvo com sucesso", { autoClose: 300 });
                    this.modalEndereco(false);
                })
                .catch((error) => {
                    console.log(error)
                })
                .finally(() => {
                    this.loading = false;
                    this.resetForm()
                })
        },

        buscacep() {
            if (this.formAddress.zip_code.length < 9) {
                this.errors.zip_code = ["Informe um cep valido"];
                return;
            }

            this.getCepViaCep(this.formAddress.zip_code)
                .then((res) => {
                    const { data } = res;
                    this.formAddress.city = data?.localidade;
                    this.formAddress.district = data?.bairro;
                    this.formAddress.address = data?.logradouro;
                    this.formAddress.state = data?.uf
                    this.formAddress.complement = data?.complemento
                })
                .catch((error) => {
                    toast.error("Informe um CEP válido", { autoClose: 300 });
                })
        },

        validateForm() {
            if (this.formAddress.zip_code.length < 9) {
                this.canSaveAddress = false;
                return this.errors.zip_code = ["Informe um cep valido"];
            }
            if (!this.formAddress.state) {
                this.canSaveAddress = false;
                return this.errors.state = ["O estado é um campo obrigatório"];
            }
            if (!this.formAddress.city) {
                this.canSaveAddress = false;
                return this.errors.city = ["A cidade campo obrigatório"];
            }
            if (!this.formAddress.district) {
                this.canSaveAddress = false;
                return this.errors.district = ["O bairro é um campo obrigatório"];
            }
            if (!this.formAddress.address) {
                this.canSaveAddress = false
                return this.errors.address = ["A rua é um campo obrigatório"];
            }

            if (!this.formAddress.complement) {
                this.canSaveAddress = false
                return this.errors.complement = ["O complemento campo obrigatório"];
            }


            this.canSaveAddress = true;
        },

        reset() {
            this.errors = { address: "", zip_code: "", state: "", city: "", district: "", number: "", complement: "", troco: "" }
        },

        resetForm() {
            this.formAddress = { address: "", zip_code: "", state: "", city: "", district: "", number: "", complement: "" }
        },

        getShippingValue(cep) {
            this.errorMessage = "";
            const params = {
                "cep": cep.replace("-", ""),
                "cartPrice": this.total
            }
            return this.shippingValue(params)
        },
        setStep(obj) {
            this.step = obj;
        }
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
        },
    },
};
</script>