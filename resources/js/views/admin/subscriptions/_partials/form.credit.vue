<template>
    <form id="pay">
        <div class="row">
            <div class="form-group mt-2 col-md-8">
                <label class="mb-1">
                    <span>
                        <img id="secure_thumbnail">
                    </span>
                    Número do cartão:
                </label>
                <input type="text" id="cardNumber" placeholder="____ ____ ____ ____" v-mask="'#### #### #### ####'"
                    v-model="cardnumber" class="form-control form-control-sm" data-checkout="cardNumber" />
            </div>
            <div class="form-group mt-2 col-md-4">
                <label class="mb-1">Vencimento:</label>
                <input type="text" v-model="expiration" placeholder="" v-mask="'##/####'"
                    class="form-control form-control-sm" />

                <input type="hidden" id="cardExpirationMonth" :value="card_expiration.expirationMonth"
                    data-checkout="cardExpirationMonth" />
                <input type="hidden" id="cardExpirationYear" :value="card_expiration.expirationYear"
                    data-checkout="cardExpirationYear" />
                <input type="hidden" id="paymentMethodId" />
                <input type="hidden" id="transactionAmount" value="100" />

            </div>
            <div class="form-group mt-2 col-md-8">
                <label class="mb-1">Nome impresso no cartão:</label>
                <input type="text" id="cardholderName" placeholder="" class="text-uppercase form-control form-control-sm"
                    data-checkout="cardholderName" />
            </div>
            <div class="form-group mt-2 col-md-4">
                <label class="mb-1">CVV:</label>
                <input type="text" id="securityCode" placeholder="" v-mask="'###'" class="form-control form-control-sm"
                    data-checkout="securityCode" />
            </div>

            <!-- <div class="form-group mt-2 col-md-4">
                <label class="mb-1">Banco emissor:</label>
                <select class="form-select form-select-sm" id="issuer" data-checkout="issuer" @change="getInstallments">
                </select>
            </div> -->

            <div class="form-group mt-2 col-md-12" v-if="showstallmants">
                <label class="mb-1">Parcelas:</label>
                <select class="form-select form-select-sm" id="installments">
                </select>
            </div>

            <div class="form-group mt-2 col-md-12">
                <label class="mb-1">EMAIL:</label>
                <input type="email" id="email" placeholder="" class="form-control form-control-sm" />
            </div>
            <div class="form-group mt-2 col-md-12">
                <label class="mb-1">CPF:</label>
                <input type="text" v-model="cpf" placeholder="" v-mask="'###.###.###-##'"
                    class="form-control form-control-sm" />
                <input id="docType" value="CPF" data-checkout="docType" type="hidden" />
                <input id="docNumber" :value="cpf" data-checkout="docNumber" type="hidden" />
            </div>
            <div class="text-right mt-2 d-grid gap-2">
                <button type="submit" id="form-checkout__submit" class="btn btn-success" :disabled="loadPayment"
                    @click.prevent="_payCard"> {{ loadPayment ?
                        'Processando...' : 'Pagar' }}</button>
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
            cardnumber: "",
            cpf: "",
            expiration: "",
            card_expiration: {
                expirationMonth: "",
                expirationYear: ""
            },
            showstallmants: false
        }
    },
    computed: {},
    methods: {
        _payCard() {
            this.loadPayment = true;
            document.getElementById('docNumber').value = this.cpf.replace(/[^a-zA-Z0-9]/g, '');
            window.Mercadopago.createToken(document.getElementById('pay'), this.setCardTokenAndPay);
        },

        setCardTokenAndPay(status, response) {
            if (status == 200 || status == 201) {
                const parcelas = document.getElementById('installments');
                axios.post('/api/v1/paycard', {
                    token: response.id,
                    payment_method_id: document.getElementById('paymentMethodId').value,
                    plan_id: this.plan.id,
                    email: document.getElementById('email').value,
                    installments: parcelas?.value ?? 1,
                    cpf: this.cpf.replace(/[^a-zA-Z0-9]/g, '')
                })
                    .then((res) => {
                        const { data } = res;
                        toast.success("Transação realizado com sucesso", { autoClose: 3000 });
                        window.location.href = data.redirect;
                    })
                    .catch((error) => {
                        this.clearCardForm();
                        toast.error("Erro na transação", { autoClose: 3000 });
                    })
                    .finally(() => {
                        this.loadPayment = false;
                    })

            } else {
                this.loadPayment = false;
                this._setError(response.cause[0].code)
            }
        },

        setPaymentMethod(status, response) {
            if (status == 200) {
                document.getElementById('paymentMethodId').value = response[0].id
                document.getElementById('secure_thumbnail').src = response[0].secure_thumbnail
                // this.getIssuers(response[0].id);
            } else {
                alert(`${response}`)
            }
        },

        getIssuers(paymentMethodId) {
            window.Mercadopago.getIssuers(
                paymentMethodId,
                this.setIssuers
            );
        },

        setIssuers(status, response) {
            if (status == 200) {
                let issuerSelect = document.getElementById('issuer');
                response.forEach(issuer => {
                    let opt = document.createElement('option');
                    opt.text = issuer.name;
                    opt.value = issuer.id;
                    issuerSelect.appendChild(opt);
                });
            } else {
                alert(`issuers method info error: ${response}`);
            }
        },

        getInstallments() {
            window.Mercadopago.getInstallments({
                "payment_method_id": document.getElementById('paymentMethodId').value,
                "amount": parseFloat(document.getElementById('transactionAmount').value),
                "issuer_id": 25
            }, this.setInstallments);
        },

        setInstallments(status, response) {
            if (status == 200) {
                this.showstallmants = true;
                document.getElementById('installments').options.length = 0;
                response[0].payer_costs.forEach(payerCost => {
                    let opt = document.createElement('option');
                    opt.text = payerCost.recommended_message;
                    opt.value = payerCost.installments;
                    document.getElementById('installments').appendChild(opt);
                });
            } else {
                this.showstallmants = false;
                // alert(`installments method info error: ${response}`);
            }
        },

        _setError(errorCode) {
            if (errorCode === '205') {
                toast.error('Digite o número do seu cartão.', { autoClose: 3000 })
            }

            if (errorCode === 'E301') {
                toast.error('Número do cartão inválido.', { autoClose: 3000 })
            }

            if (errorCode === 'E302') {
                toast.error('Confira o código de segurança.', { autoClose: 3000 })
            }

            if (errorCode === '221') {
                toast.error('Digite o nome impresso no cartão.', { autoClose: 3000 })
            }

            if (errorCode === '208' || errorCode === '209') {
                toast.error('Digite o vencimento cartão.', { autoClose: 3000 })
            }

            if (errorCode === '325' || errorCode === '326') {
                toast.error('Vencimento do cartão inválido.', { autoClose: 3000 })
            }

            if (errorCode === '214') {
                toast.error('Informe o número do seu CPF.', { autoClose: 3000 })
            }

            if (errorCode === '324') {
                toast.error('Número do CPF inválido.', { autoClose: 3000 })
            }
        },
        clearCardForm() {
            document.getElementById('cardNumber').value = ""
            document.getElementById('secure_thumbnail').src = ""
            document.getElementById('cardExpirationMonth').value = ""
            document.getElementById('cardExpirationYear').value = ""
            document.getElementById('paymentMethodId').value = ""
            document.getElementById('cardholderName').value = ""
            document.getElementById('securityCode').value = ""
            document.getElementById('email').value = ""
            document.getElementById('docType').value = ""
            document.getElementById('docNumber').value = ""

            this.cardnumber = "",
                this.cpf = "";
            this.expiration = "",
                this.card_expiration = {
                    expirationMonth: "",
                    expirationYear: ""
                },
                this.showstallmants = false
        }
    },
    watch: {
        cardnumber() {
            let val = this.cardnumber.replace(/\s/g, '');
            if (val.length >= 7) {
                window.Mercadopago.getPaymentMethod({
                    "bin": val.substring(0, 6)
                }, this.setPaymentMethod);
            }

            if (val.length == 16) {
                this.getInstallments()
            }
        },

        expiration() {
            if (this.expiration.includes('/')) {
                const exp = this.expiration.split('/');
                this.card_expiration.expirationMonth = exp[0];
                this.card_expiration.expirationYear = exp[1];
            }
        }
    }
}
</script>