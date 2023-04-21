<template>
    <div>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn load_more_btn" @click.prevent="modalEndereco(true)">Adicionar</button>
        </div>

        <div v-if="address.data.length > 0">
            <div cla v-for="(item, index) in address.data" :key="index" @click.prevent="setAddress(item)" class="card mt-1"
                style="cursor: pointer;">
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

    <template v-if="loading">
        <div class="text-center mt-2">
            <i class="fas fa-spinner fa-spin"></i> Buscando...
        </div>
    </template>

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
                    <div class="form-group mt-2 col-md-4" v-if="me.hasIdDoc == 'N'">
                        <label>Informe seu CPF:</label>
                        <input type="text" v-model="formAddress.cpf" class="form-control form-control-sm" placeholder="CPF"
                            v-mask="'###.###.###-##'">
                        <div class="form-text text-danger" v-if="errors.cpf != ''">
                            {{ errors.cpf[0] || "" }}
                        </div>
                    </div>

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
import ModalComponent from '../../../../../components/widgets/ModalComponent.vue';
import { mapState, mapActions, mapMutations } from "vuex";
import { toast } from 'vue3-toastify';

export default {
    components: {
        ModalComponent,
    },
    data: () => ({
        isModalEnderecoVisible: false,
        loading: false,
        canSaveAddress: false,
        formAddress: {
            cpf: "",
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
            cpf: "",
            address: "",
            zip_code: "",
            state: "",
            city: "",
            district: "",
            number: "",
            complement: "",
            troco: ""
        },
    }),
    computed: {
        ...mapState({
            address: (state) => state.auth.address,
            company: (state) => state.tenant.company,
            me: (state) => state.auth.me,
            paleta: (state) => state.layout.paleta,
            total: (state) => state.cart.total,
        }),
    },
    methods: {
        ...mapActions(["getCepViaCep", "saveNewAddress", "shippingValue"]),
        ...mapMutations({
            setSelectedAddress: "SET_SELECTED_ADDRESS",
            setShippingMethods: "SET_SHIPPING_METHODS",
            setSelectedShippingMethod: "SET_SELECTED_SHIPPING_METHOD",
            setSelectedPaymentMethod: "SET_SELECTED_PAYMENT_METHOD",
            setPaymentMethods: "SET_PAYMENT_METHODS",
            setStep: "SET_STEP"
        }),
        modalEndereco(state) {
            this.resetForm();
            if (!state) {
                this.resetForm();
                this.reset();
            }
            return this.isModalEnderecoVisible = state;
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
                .then(() => {
                    this.setStep(1)
                })
                .catch((error) => {
                    if (error?.response?.data?.message) {
                        this.errorMessage = error.response.data.message;
                    }
                    toast.error(
                        "Houve um erro ao buscar as formas de entrega, tente novamente",
                        { autoClose: 5000 }
                    );
                })
                .finally(() => {
                    this.loading = false
                });
        },

        salveAddress() {
            this.reset();
            this.validateForm();
            if (!this.canSaveAddress) return;

            this.loading = true;

            this.saveNewAddress(this.formAddress)
                .then((res) => {
                    toast.success("Endereço salvo com sucesso", { autoClose: 300 });
                    this.modalEndereco(false);
                    this.resetForm()
                })
                .catch((error) => {
                    const errorResponse = error.response;
                    this.errors = Object.assign(this.errors, errorResponse.data.errors);
                    toast.error(
                        "Falha na operação",
                        { autoClose: 5000 }
                    );
                })
                .finally(() => {
                    this.loading = false;
                })
        },
        getShippingValue(cep) {
            this.errorMessage = "";
            const params = {
                "cep": cep.replace("-", ""),
                "cartPrice": this.total
            }
            return this.shippingValue(params)
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

            if (this.me.hasIdDoc == 'N') {
                if (!this.formAddress.cpf) {
                    this.canSaveAddress = false
                    return this.errors.cpf = ["O CPF é um campo obrigatório"];
                }

                if (this.formAddress.cpf?.length < 14) {
                    this.canSaveAddress = false
                    return this.errors.cpf = ["A quantida de caracteres informádo é inválido"];
                }
            }


            this.canSaveAddress = true;
        },
        reset() {
            this.errors = { cpf: "", address: "", zip_code: "", state: "", city: "", district: "", number: "", complement: "", troco: "" }
        },
        resetForm() {
            this.formAddress = { address: "", zip_code: "", state: "", city: "", district: "", number: "", complement: "" }
        },
    }
}
</script>