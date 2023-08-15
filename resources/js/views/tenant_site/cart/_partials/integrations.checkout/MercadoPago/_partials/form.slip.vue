<template>
    <form id="pay">
        <div class="row">
            <div class="form-group mt-2 col-md-12">
                <label class="mb-1">
                    Nome
                </label>
                <input type="text" v-model="firstname" class="form-control form-control-sm" />
                <div class="form-text text-danger" v-if="errors.firstname != ''">
                    {{ errors.firstname[0] || "" }}
                </div>
            </div>
            <div class="form-group mt-2 col-md-12">
                <label class="mb-1">
                    Sobrenome
                </label>
                <input type="text" v-model="lastname" class="form-control form-control-sm" />
                <div class="form-text text-danger" v-if="errors.lastname != ''">
                    {{ errors.lastname[0] || "" }}
                </div>
            </div>
            <div class="form-group mt-2 col-md-12">
                <label class="mb-1">EMAIL:</label>
                <input type="email" v-model="email" class="form-control form-control-sm" />
                <div class="form-text text-danger" v-if="errors.email != ''">
                    {{ errors.email[0] || "" }}
                </div>
            </div>

            <div class="form-group mt-2 col-md-12">
                <label class="mb-1">CPF:</label>
                <input type="text" v-model="cpf" v-mask="'###.###.###-##'" class="form-control form-control-sm" />
                <div class="form-text text-danger" v-if="errors.cpf != ''">
                    {{ errors.cpf[0] || "" }}
                </div>
                <input id="docType" value="CPF" data-checkout="docType" type="hidden" />
                <input id="docNumber" :value="cpf" data-checkout="docNumber" type="hidden" />
            </div>
            <div class="text-right mt-2 d-grid gap-2">
                <button type="submit" id="form-checkout__submit" class="btn btn-success" @click.prevent="pay"> Pagar
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import { mapState, mapActions, mapMutations, commit } from "vuex";
import { toast } from 'vue3-toastify';

export default {
    props: [],
    components: {},
    data: () => ({
        token_name: "buzzin",
        canSave: false,
        firstname: "",
        lastname: "",
        cpf: "",
        email: "",
        errors: {
            cpf: "",
            firstname: "",
            lastname: "",
            email: ""
        },
    }),
    computed: {
        ...mapState({
            selectedPaymentMethod: (state) => state.cart.selectedPaymentMethod,
            selectedAddress: (state) => state.cart.selectedAddress,
            products: (state) => state.cart.products.data,
            shippingMethods: (state) => state.cart.shippingMethods,
            comment: (state) => state.cart.comment,
            troco: (state) => state.cart.troco,
            precisa_troco: (state) => state.cart.precisa_troco,
            selectedShippingMethod: (state) => state.cart.selectedShippingMethod,
            company: (state) => state.tenant.company
        }),
        mpConfig() {
            return JSON.parse(this.selectedPaymentMethod.data);
        }
    },
    created() {
        const script = document.createElement('script');
        script.src = 'https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js'
        script.addEventListener('load', () => {
            window.Mercadopago.setPublishableKey(this.mpConfig.public_key)
        })
        document.body.appendChild(script)

        let iframe = document.querySelector('iframe');
        if (iframe) {
            document.body.removeChild(iframe);
            document.body.removeChild(script);
        }
    },
    methods: {
        ...mapMutations({
            clearCart: "CLEAR_CART",
            setPreloader: "SET_PRELOADER",
            setTextPreloader: "SET_TEXT_PRELOADER"
        }),

        pay() {
            this.reset();
            this.validateForm();
            if (!this.canSave) {
                return;
            }

            const params = {
                address: this.selectedAddress,
                products: this.products,
                shippingMethod: this.selectedShippingMethod,
                comment: this.comment,
                paymentMethod: this.selectedPaymentMethod,
                precisaTroco: this.precisa_troco ? "Y" : "N",
                troco: this.troco ? this.troco : 0,
                payment_integration_params: {
                    first_name: this.firstname,
                    last_name: this.lastname,
                    payment_method_id: 'slip',
                    email: this.email,
                    cpf: this.cpf.replace(/[^a-zA-Z0-9]/g, '')
                }
            }

            const token = localStorage.getItem(this.token_name);

            this.setPreloader(true);
            this.setTextPreloader('Finalizando pedido...')

            const query_params = new URLSearchParams({
                token_company: this.company.uuid
            }).toString();

            const endpoint = `/api/auth/v1/mp-order?${query_params}`
            return axios.post(endpoint, params, {
                headers: { 'Authorization': `Bearer ${token}` }
            })
                .then((res) => {
                    const { data } = res.data;
                    toast.success("Pedido realizado com sucesso", { autoClose: 3000 });
                    this.clearCart(this.company.uuid);
                    window.location.href = `http://${this.company.subdomain}/app/cliente-area?identify=${data.identify}`;
                })
                .catch((error) => {
                    if (error?.response) {
                        const errorResponse = error.response;
                        this.errors = Object.assign(this.errors, errorResponse.data.errors);
                    }

                    toast.error(
                        "Falha ao gerar boleto, tente novamente",
                        { autoClose: 5000 }
                    );
                })
                .finally(() => {
                    this.setPreloader(false);
                    this.setTextPreloader('Carregando...');
                });
        },

        validateForm() {
            if (!this.firstname) {
                this.canSave = false;
                return this.errors.firstname = ["O nome é um campo obrigatório"];
            }
            if (!this.lastname) {
                this.canSave = false;
                return this.errors.lastname = ["O sobrenome é um campo obrigatório"];
            }
            if (!this.email) {
                this.canSave = false;
                return this.errors.email = ["O email é um campo obrigatório"];
            }

            if (!this.cpf) {
                this.canSave = false
                return this.errors.cpf = ["O CPF é um campo obrigatório"];
            }

            if (this.cpf?.length < 14) {
                this.canSave = false
                return this.errors.cpf = ["A quantida de caracteres informádo é inválido"];
            }

            this.canSave = true;
        },

        clearCardForm() {
            this.firstname = "";
            this.lastname = "";
            this.cpf = "";
            this.email = "";
        },
        reset() {
            this.canSave = false;
            this.errors = {
                cpf: "",
                firstname: "",
                lastname: "",
                email: ""
            }
        },
        b64: function (str) {
            return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
                function toSolidBytes(match, p1) {
                    return String.fromCharCode('0x' + p1);
                }));
        },
        b64D: function (str) {
            return decodeURIComponent(atob(str).split('').map(function (c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
        },
        reverse(s) {
            return s.split("").reverse().join("");
        },

        decode(value) {
            value = this.reverse(value);
            const aces = 10;
            var count = 0;
            while (true) {
                if (count === aces) break;
                value = this.b64D(value);
                count++;
            }
            return value;
        },

        encode(value) {
            const aces = 10;
            var count = 0;
            while (true) {
                if (count === aces) break;
                value = this.b64(value);
                count++;
            }
            return this.reverse(value);
        },
    }
}
</script>
