<template>
    <div class="container pt-5 pb-3">
        <div class="my-4 d-flex justify-content-between">
            <h4 class="title-tenant">Meus endereços de entrega</h4>

            <button type="button" class="h-100 btn save_address_button" @click.prevent="openDetailsAddress()">
                Add
            </button>
        </div>
        <template v-if="addresses.length > 0">
            <div class="my-orders my-4">
                <div class="my-table-header mb-4">
                    <div class="text-center"><b>Rua</b></div>
                    <div class="text-center"><b>Bairro</b></div>
                    <div class="text-center"><b>Cidade</b></div>
                    <div class="text-center"><b>Detalhes</b></div>
                </div>

                <div class="my-table" v-for="(address, index) in addresses">
                    <div class="text-center">{{ address.address }}</div>
                    <div class="text-center">{{ address.district }}</div>
                    <div class="text-center">{{ address.city }}</div>
                    <div class="text-center">
                        <button type="button" class="btn detail-button me-2" @click.prevent="openDetailsAddress(address)">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-xs" @click.prevent="deleteAddress(address)">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="alert alert-warning">
                Você ainda não possui endereço(s) cadastrado(s) :(
            </div>
        </template>
    </div>

    <detail-address :display="displayAddress" @closeDetailsAddress="closeDetailsAddress">
        <template v-slot:content>
            <div class="d-flex justify-content-end">
                <button type="button" class="btn save_address_button" @click.prevent="saveAddress()" :disabled="loading">
                    <span v-if="loading">Salvando...</span>
                    <span v-else> Salvar</span>
                </button>
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
                    <input type="text" v-model="formAddress.city" class="form-control form-control-sm" placeholder="Cidade:"
                        readonly>
                    <div class="form-text text-danger" v-if="errors.city != ''">
                        {{ errors.city[0] || "" }}
                    </div>
                </div>

                <div class="form-group mt-2 col-md-2">

                    <label>UF: *</label>
                    <input type="text" v-model="formAddress.state" class="form-control form-control-sm" placeholder="UF:"
                        readonly>
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
        </template>
    </detail-address>
</template>

<style scoped>
.detail-button:hover {
    background: v-bind("paleta.btn_color_hover") !important;
}

.detail-button {
    background: v-bind("paleta.btn_color") !important;
    color: v-bind("paleta.btn_color_letter") !important;
}

.save_address_button {
    background: v-bind("paleta.btn_color") !important;
    color: v-bind("paleta.btn_color_letter") !important;
    border-radius: 25px !important;
}

.calcel-button {
    background: v-bind("paleta.btn_color_hover") !important;
    color: v-bind("paleta.btn_color_letter") !important;
    border-radius: 25px !important;
}

.save_address_button:hover {
    background: v-bind("paleta.btn_color_hover") !important;
}
</style>

<script>
import { mapActions, mapState } from "vuex";
import DetailAddress from './_partials/DetailAddress'
import { toast } from 'vue3-toastify';

export default {
    props: [],
    components: {
        DetailAddress
    },
    data: () => ({
        canSaveAdrdess: false,
        loading: false,
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
        displayAddress: 'none',
    }),
    computed: {
        ...mapState({
            paleta: (state) => state.layout.paleta,
            addresses: (state) => state.auth.address.data,
        })
    },
    created() { },
    mounted() {
        this.getClientAddress()
    },
    methods: {
        ...mapActions([
            "getClientAddress",
            "removeAddress",
            "getCepViaCep",
            "saveNewAddress"

        ]),
        saveAddress() {
            this.reset();
            this.validateForm();

            if (!this.canSaveAddress) return;

            this.loading = true;

            this.saveNewAddress(this.formAddress)
                .then((res) => {
                    if(this.formAddress.id) {
                        toast.success("Endereço atualizado com sucesso", { autoClose: 3000 });
                    }else {
                        toast.success("Endereço salvo com sucesso", { autoClose: 3000 });
                    }
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
                    this.closeDetailsAddress()
                    this.getClientAddress()
                })

        },
        deleteAddress(address) {
            if (confirm("Tem certeza que deseja apagar este endereço?")) {
                this.removeAddress(address)
                .then((res) => {
                    toast.success("Endereço removido com sucesso", { autoClose: 3000 });
                })
                .catch((error) => {
                    const errorResponse = error.response;
                    this.errors = Object.assign(this.errors, errorResponse.data.errors);
                    toast.error(
                        "Falha na operação",
                        { autoClose: 5000 }
                    );
                })
            }
        },
        openDetailsAddress(address = null) {
            if (address) this.formAddress = address;

            this.displayAddress = 'block'
        },
        closeDetailsAddress() {
            this.formAddress = {
                address: "",
                zip_code: "",
                state: "",
                city: "",
                district: "",
                number: "",
                complement: "",
                id: ""
            }
            this.displayAddress = 'none'
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
    },

}
</script>