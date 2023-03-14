<template>
    <div class="">
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

        <hr>

        <div class="mt-4">
            <a href="" class="cart-finalizar" @click.prevent="openModalCheckout(true)" v-if="!checkout">Finalizar</a>
        </div>
    </div>

    <ModalComponent v-show="isModalVisible" title="Pedido" @close="openModalCheckout(false)">
        <template v-slot:content>
            <div name="checkout-order" :heigth="350">
                <!-- <div class="px-md-5 my-4" v-if="loading">
                        <p>Gerando o pedido... (aguarde!)</p>
                    </div> -->
                <div class="px-md-5 my-4">
                    <div class="col-12" v-if="me.name == ''">
                        <div class="">
                            <div class="alert alert-warning">
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

    <ModalComponent v-show="isModalEnderecoVisible" title="Selecione um endereço" @close="modalEndereco(false)">
        <template v-slot:content>
            <div name="checkout-order" :heigth="350">
                <div class="d-flex justify-content-end" v-if="!showFormAddress && !selectedAddress.zip_code">
                    <button type="button" class="btn load_more_btn" @click.prevent="showForm(true)">Adicionar</button>
                </div>
                <div class="d-flex justify-content-end" v-if="!showFormAddress && selectedAddress.zip_code">
                    <button type="button" class="btn load_more_btn" @click.prevent="backAddressList()">
                        <i class="fa-solid fa-chevron-left"></i>
                        Voltar
                    </button>
                </div>
                <div class="d-flex justify-content-end" v-if="showFormAddress">
                    <button type="button" class="btn calcel-button me-2" @click.prevent="showForm(false)">Cancelar</button>
                    <button type="button" class="btn load_more_btn" @click.prevent="salveAddress()" :disabled="loading">
                        <span v-if="loading">Salvando...</span>
                        <span v-else> Salvar</span>
                    </button>
                </div>
                <template v-if="!showFormAddress">
                    <div class="px-md-5 my-4" v-if="address.data.length > 0">
                        <template v-if="selectedAddress.zip_code">
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ selectedAddress.address }} <span
                                                v-if="selectedAddress.number">n: {{ selectedAddress.number
                                                }}</span>
                                            {{ selectedAddress.district }}</h5>
                                        <!-- <small class="badge bg-success" v-if="selectedAddress.status == 1">Endereço principal</small> -->
                                    </div>
                                    <p class="mb-1"> {{ selectedAddress.complement }} {{ selectedAddress.city }} - {{
                                        selectedAddress.state }}</p>
                                    <small class="text-muted">{{ selectedAddress.zip_code }}</small>
                                </a>

                                <template v-if="shippingMethods.data.length > 0">
                                    <div class="mt-2">
                                        <div class="title mb-1 text-center">
                                            <h5>Selecione a forma de entrega</h5>
                                        </div>
                                        <div class="form-check" v-for="(method, index) in shippingMethods.data"
                                            :key="index">
                                            <input class="form-check-input" name="exampleRadios" type="radio"
                                                :id="`radio${index}`" @change.prevent="setShippingSelected(method)">
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
                                    <div class="alert alert-danger mt-2" v-if="errorMessage">
                                        {{ errorMessage }} :(
                                    </div>
                                </template>

                                <template v-if="loading">
                                    <div>
                                        <i class="fas fa-spinner fa-spin"></i> Buscando...
                                    </div>
                                </template>
                            </div>
                        </template>

                        <template v-if="!selectedAddress.zip_code">
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action"
                                    v-for="(item, index) in address.data" :key="index" @click.prevent="setAddress(item)">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ item.address }} <span v-if="item.number">n: {{ item.number
                                        }}</span>
                                            {{ item.district }}</h5>
                                        <!-- <small class="badge bg-success" v-if="item.status == 1">Endereço principal</small> -->
                                    </div>
                                    <p class="mb-1"> {{ item.complement }} {{ item.city }} - {{ item.state }}</p>
                                    <small class="text-muted">{{ item.zip_code }}</small>
                                </a>
                            </div>

                        </template>

                    </div>
                    <div class="mt-2" v-else>
                        <div class="alert alert-warning text-center"> Você não possuí endereços cadastrados </div>
                    </div>
                </template>

                <template v-if="showFormAddress">
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
                </template>
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

export default {
    components: {
        ModalComponent
    },
    data() {
        return {
            modalTitle: "Checkout",
            cartCep: "",
            isModalVisible: false,
            isModalEnderecoVisible: false,
            loading: false,
            comment: "",
            errorMessage: "",
            disabledCart: false,
            showFormAddress: false,
            canSaveAddress: false,
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
                complement: ""
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
            checkout: (state) => state.cart.isInCheckout,
            selectedAddress: (state) => state.cart.selectedAddress,
            shippingMethods: (state) => state.cart.shippingMethods
        })
    },
    methods: {
        ...mapActions(["shippingValue", "getClientAddress", "getCepViaCep", "saveNewAddress"]),
        ...mapMutations({
            setInCheckout: "SET_IS_IN_CHECKOUT",
            setSelectedAddress: "SET_SELECTED_ADDRESS",
            setShippingMethods: "SET_SHIPPING_METHODS"
        }),
        createOrder() {
            // this.loading = true;
            // const action = this.me.name === "" ? "create_order" : "create_order_auth";
            // let params = {
            //     token_company: this.company.uuid,
            //     comment: this.comment,
            //     products: [...this.products],
            // };
            // this.$store
            //     .dispatch(action, params)
            //     .then((res) => {
            //         this.$vToastify.success("Pedido realizado com sucesso", "Parabéns");
            //         this.$router.push({
            //             name: "detail.order",
            //             params: { identify: res.identify },
            //         });
            //     })
            //     .catch((res) => {
            //         this.$vToastify.error(
            //             "Falha ao realizar o pedido, tente mais tarde :(",
            //             "Erro"
            //         );
            //     })
            //     .finally((res) => {
            //         this.loading = false;
            //     });
        },

        setShippingSelected(item) {
            console.log(item)
        },
        backAddressList() {
            this.setSelectedAddress(this.formAddress);
            this.setShippingMethods({ data: [] })
        },
        openModalCheckout(state) {
            if (this.me.name !== '') {
                this.modalEndereco(true);
                this.setInCheckout(true);
                this.getClientAddress();
                return;
            }
            this.isModalVisible = state;
        },
        modalEndereco(state) {
            this.resetForm();
            if (!state && !this.formAddress.id) {
                this.setInCheckout(false);
            }

            if (!this.selectedAddress.zip_code && this.shippingMethods.data.length > 0 && state) {
                this.setShippingMethods({ data: [] })
            }
            return this.isModalEnderecoVisible = state;
        },

        showForm(state) {
            this.showFormAddress = state
        },

        setAddress(item) {
            this.loading = true;
            this.setSelectedAddress(item);
            this.getShippingValue(item.zip_code)
                .catch((error) => {
                    if (error?.response?.data?.message) {
                        this.errorMessage = error.response.data.message;
                    }
                })
                .finally(() => this.loading = false);
        },

        salveAddress() {
            this.reset();
            this.validateForm();
            if (!this.canSaveAddress) return;

            this.loading = true;

            this.saveNewAddress(this.formAddress)
                .then((res) => {
                    this.showFormAddress = false
                    toast.success("Endereço salvo com sucesso", { autoClose: 300 });
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
            this.errors = { address: "", zip_code: "", state: "", city: "", district: "", number: "", complement: "" }
        },

        resetForm() {
            this.formAddress = { address: "", zip_code: "", state: "", city: "", district: "", number: "", complement: "" }
        },

        getShippingValue(cep) {
            const params = {
                "cep": cep.replace("-", ""),
                "cartPrice": this.total
            }
            return this.shippingValue(params)
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
        }
    },
};
</script>