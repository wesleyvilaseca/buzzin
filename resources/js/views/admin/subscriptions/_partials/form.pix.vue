<template>
    <form id="pay">
        <div class="row" v-if="!qrcode?.qrcode64">
            <div class="form-group mt-2 col-md-12">
                <label class="mb-1">
                    Nome
                </label>
                <input type="text" v-model="firstname" class="form-control form-control-sm" />
                <div class="form-text text-danger" v-if="errors.firsname != ''">
                    {{ firsname.cpf[0] || "" }}
                </div>
            </div>
            <div class="form-group mt-2 col-md-12">
                <label class="mb-1">
                    Sobrenome
                </label>
                <input type="text" v-model="lastname" class="form-control form-control-sm" />
                <div class="form-text text-danger" v-if="errors.lastname != ''">
                    {{ lastname.cpf[0] || "" }}
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
                <button type="submit" id="form-checkout__submit" class="btn btn-success" :disabled="loadPayment"
                    @click.prevent="pay"> {{ loadPayment ?
                        'Processando...' : 'Pagar' }}</button>
            </div>
        </div>
        <div v-else>
            <div class="qrcode text-center p-2">
                <div class="title">Qrcode</div>
                <div class="image">
                    <img :src="`data:image/jpeg;base64,${qrcode.qrcode64}`" style="max-width: 300px" id="base64image">
                </div>
            </div>
            <div class="copie">
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Copie:</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="6" readonly>{{ qrcode.qrcode }}</textarea>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import { toast } from 'vue3-toastify';

export default {
    props: {
        tenant: Object,
        plan: Object
    },
    components: {},
    created() {
        const script = document.createElement('script')
        script.src = 'https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js'
        script.addEventListener('load', () => {
            window.Mercadopago.setPublishableKey(this.tenant.mpkey)
        })
        document.body.appendChild(script)

        let iframe = document.querySelector('iframe');
        if (iframe) {
            document.body.removeChild(iframe);
            document.body.removeChild(script);
        }
    },
    mounted() { },
    data() {
        return {
            loadPayment: false,
            firstname: "",
            lastname: "",
            cpf: "",
            email: "",
            errors: {
                cpf: "",
                firsname: "",
                lastname: "",
                email: ""
            },
            qrcode: {}
        }
    },
    computed: {},
    methods: {
        pay(status, response) {
            this.reset();
            this.loadPayment = true;
            axios.post('/api/v1/pix', {
                first_name: this.firstname,
                last_name: this.lastname,
                plan_id: this.plan.id,
                payment_method_id: 'pix',
                email: this.email,
                cpf: this.cpf.replace(/[^a-zA-Z0-9]/g, '')
            })
                .then((res) => {
                    const { data } = res;
                    toast.success("Pix gerado com sucesso", { autoClose: 3000 });
                    this.qrcode = data.data;
                })
                .catch((error) => {
                    this.clearCardForm();
                    const errorResponse = error.response;
                    this.errors = Object.assign(this.errors, errorResponse.data.errors);
                    toast.error(
                        "Falha na operação",
                        { autoClose: 5000 }
                    );
                })
                .finally(() => {
                    this.loadPayment = false;
                })
        },

        validateForm() {
            if (!this.firstname) {
                this.canSave = false;
                return this.errors.state = ["O nome é um campo obrigatório"];
            }
            if (!this.lastname) {
                this.canSave = false;
                return this.errors.city = ["O sobrenome é um campo obrigatório"];
            }
            if (!this.email) {
                this.canSave = false;
                return this.errors.district = ["O email é um campo obrigatório"];
            }

            if (!this.cpf) {
                this.canSaveAddress = false
                return this.errors.cpf = ["O CPF é um campo obrigatório"];
            }

            if (this.cpf?.length < 14) {
                this.canSaveAddress = false
                return this.errors.cpf = ["A quantida de caracteres informádo é inválido"];
            }


            this.canSaveAddress = true;
        },


        clearCardForm() {
            this.loadPayment = false;
            this.firstname = "";
            this.lastname = "";
            this.cpf = "";
            this.email = "";
        },
        reset() {
            this.errors.cpf = ""
        }
    },
    watch: {}
}
</script>