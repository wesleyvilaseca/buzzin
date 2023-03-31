<template>
    <div>
        <PreloaderComponent />
        <div class="text-center">
            <h1 class="title-plan">Escolha o plano</h1>
        </div>
        <template v-if="listPlans.data.length > 0">
            <div class="row">
                <div class="col-md-4 col-sm-6" v-for="(plan, index) in listPlans.data" :key="index">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #fff;">
                            <div class="position-relative">
                                <div class="position-absolute" v-if="hasSelectedPlan">
                                    <span class="badge bg-dark text-light" @click.prevent="unSelectPlan()"
                                        style="cursor:pointer">
                                        <i class="fa-solid fa-chevron-left"></i>
                                        Escolher outro plano
                                    </span>
                                </div>

                                <div class="position-absolute" v-if="plan.id == tenant.plan_id && !hasSelectedPlan">
                                    <span class="badge bg-primary">Plano atual</span>
                                </div>
                                <h5 class="fw-bold">{{ plan.name }}</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="inner-content">
                                <div class="text-center">
                                    <span class="">R$
                                        <span class="fw-bold fs-1">{{ plan.price }}</span>
                                    </span>
                                </div>
                                <ul class="list-group list-group-flush" v-if="plan.details.length > 0">
                                    <li class="list-group-item" v-for="(detail, index) in plan.details" :key="index">
                                        <i class="text-success fa-solid fa-check me-2"></i>
                                        {{ detail.name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-grid gap-2 m-3" v-if="!hasSelectedPlan">
                            <a class="btn btn-success" href="#" @click.prevent="selectPlan(plan)">Assinar</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-md-4" v-if="hasSelectedPlan && !selectedPaymentType">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #fff;">
                            <h5 class="fw-bold">Como você prefere pagar?</h5>
                        </div>
                        <div class="card-body">
                            <div class="payment-options">
                                <div class="option ps-3 hover-zoom"
                                    @click.prevent="setSelectedPaymentMethod('credit_card')">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <span style="font-size: 50px;">
                                                <i class="fa-solid fa-credit-card"></i>
                                            </span>
                                        </div>
                                        <div class="col-md-8 mt-1">
                                            <h6>Cartão</h6>
                                            <p class="text-muted">
                                                Crédito ou Débito
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="option ps-3 hover-zoom" @click.prevent="setSelectedPaymentMethod('slips')">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <span style="font-size: 50px;">
                                                <i class="fa-solid fa-barcode"></i>
                                            </span>
                                        </div>
                                        <div class="col-md-8 mt-1">
                                            <h6>Boleto bancário</h6>
                                            <p class="text-muted">
                                                Pagamento aprovado em 1 ou 2 dias uteis
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4" v-if="selectedPaymentType">
                    <div class="card">
                        <div class="card-header text-center" style="background-color: #fff;">
                            <div class="position-relative">
                                <div class="position-absolute" v-if="hasSelectedPlan">
                                    <span class="badge bg-dark text-light" @click.prevent="setSelectedPaymentMethod('')"
                                        style="cursor:pointer">
                                        <i class="fa-solid fa-chevron-left"></i>
                                        Mudar
                                    </span>
                                </div>
                                <h5 class="fw-bold">{{ titlePayment }}</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="pay">
                                <div class="row">
                                    <div class="form-group mt-2 col-md-8">
                                        <label class="mb-1">
                                            <span>
                                                <img id="secure_thumbnail">
                                            </span>
                                            Número do cartão:
                                        </label>
                                        <input type="text" id="cardNumber" placeholder="____ ____ ____ ____"
                                            v-mask="'#### #### #### ####'" v-model="cardnumber"
                                            class="form-control form-control-sm" data-checkout="cardNumber" />
                                    </div>
                                    <div class="form-group mt-2 col-md-4">
                                        <label class="mb-1">Vencimento:</label>
                                        <input type="text" v-model="expiration" placeholder="" v-mask="'##/####'"
                                            class="form-control form-control-sm" />

                                        <input type="hidden" id="cardExpirationMonth"
                                            :value="card_expiration.expirationMonth" data-checkout="cardExpirationMonth" />
                                        <input type="hidden" id="cardExpirationYear" :value="card_expiration.expirationYear"
                                            data-checkout="cardExpirationYear" />
                                        <input type="hidden" id="paymentMethodId" />
                                        <input type="hidden" name="transactionAmount" id="transactionAmount" value="100" />

                                    </div>
                                    <div class="form-group mt-2 col-md-8">
                                        <label class="mb-1">Nome impresso no cartão:</label>
                                        <input type="text" id="cardholderName" placeholder=""
                                            class="text-uppercase form-control form-control-sm"
                                            data-checkout="cardholderName" />
                                    </div>
                                    <div class="form-group mt-2 col-md-4">
                                        <label class="mb-1">CVV:</label>
                                        <input type="text" id="securityCode" placeholder="" v-mask="'###'"
                                            class="form-control form-control-sm" data-checkout="securityCode" />
                                    </div>

                                    <!-- <div class="form-group mt-2 col-md-4">
                                        <label class="mb-1">Banco emissor:</label>
                                        <select class="form-select form-select-sm" id="issuer" data-checkout="issuer"
                                            @change="getInstallments">
                                        </select>
                                    </div> -->

                                    <div class="form-group mt-2 col-md-12">
                                        <label class="mb-1">Parcelas:</label>
                                        <select class="form-select form-select-sm" id="installments">
                                        </select>
                                    </div>

                                    <div class="form-group mt-2 col-md-12">
                                        <label class="mb-1">EMAIL:</label>
                                        <input type="email" id="email" placeholder=""
                                            class="text-uppercase form-control form-control-sm" />
                                    </div>
                                    <div class="form-group mt-2 col-md-12">
                                        <label class="mb-1">CPF:</label>
                                        <input type="email" v-model="cpf" placeholder="" v-mask="'###.###.###-##'"
                                            class="text-uppercase form-control form-control-sm" />
                                        <input id="docType" :value="cpf" data-checkout="docType" type="hidden" />
                                        <input id="docNumber" :value="cpf" data-checkout="docNumber" type="hidden" />
                                    </div>
                                    <div class="text-right mt-2 d-grid gap-2">
                                        <button type="submit" id="form-checkout__submit" class="btn btn-success"
                                            :disabled="loadPayment" @click.prevent="_payCard"> {{ loadPayment ?
                                                'Processando...' : 'Pagar' }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="alert alert-warning text-center">
                Não há planos para listar
            </div>
        </template>
    </div>
</template>

<style scoped>
.hover-zoom {
    cursor: pointer;
    transition: transform .5s ease;
}

.hover-zoom:hover {
    transform: scale(1.01);
}

.preloader {
    position: fixed;
    background: #fff;
    opacity: .8;
    width: 100%;
    height: 100vh;
    z-index: 999999999999;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    overflow-y: hidden !important;
    overflow-x: hidden !important;
}

.preloader .img-preloader {
    max-width: 80px !important;
    /* margin-top: 10%; */
}
</style>

<script>
import { mapMutations } from "vuex";
import PreloaderComponent from '../../../components/common/PreloaderComponent.vue';
import { toast } from 'vue3-toastify';

export default {
    props: {
        tenant: Object
    },
    components: {
        PreloaderComponent
    },
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
    mounted() {
        this.getPlans()
    },
    data() {
        return {
            loadPayment: false,
            listPlans: { data: [] },
            plans: { data: [] },
            hasSelectedPlan: false,
            selectedPaymentType: "",
            cardnumber: "",
            cpf: "",
            expiration: "",
            card_expiration: {
                expirationMonth: "",
                expirationYear: ""
            }
        }
    },
    computed: {
        titlePayment() {
            if (this.selectedPaymentType == 'credit_card') {
                return 'Pagamento com cartão';
            }

            if (this.selectedPaymentType == 'slips') {
                return 'Pagamento com boleto';
            }

            return '';
        }
    },
    methods: {
        ...mapMutations({
            loading: "SET_PRELOADER",
            textLoading: "SET_TEXT_PRELOADER"
        }),
        getPlans() {
            this.reset()
            this.loading(true);
            this.textLoading('Carregando planos');

            axios.get('/api/v1/plans', {})
                .then((res) => {
                    this.plans.data = res.data;
                    this.listPlans.data = res.data;
                })
                .catch(error => alert('error'))
                .finally(() => {
                    this.loading(false)
                })
        },
        reset() {
            this.plans = { data: [] }
        },
        selectPlan(plan) {
            this.hasSelectedPlan = true;
            this.listPlans.data = [plan];
        },
        unSelectPlan() {
            this.selectedPaymentType = "";
            this.hasSelectedPlan = false;
            this.listPlans.data = this.plans.data;
        },
        setSelectedPaymentMethod(val) {
            this.selectedPaymentType = val;
        },

        _payCard() {
            window.Mercadopago.createToken(document.getElementById('pay'), this.setCardTokenAndPay());
        },

        setCardTokenAndPay(status, response) {
            if (status == 200 || status == 201) {
                this.loadPayment = true;
                axios.post('/api/v1/paycard', {
                    token: response.id,
                    payment_method_id: document.getElementById('paymentMethodId').value,
                    plan_id: this.listPlans[0].id,
                    email: this.tenant.email
                })
                    .then((res) => {
                        toast.success("Pagamento realizado com sucesso", { autoClose: 3000 });
                    })
                    .catch((error) => {
                        toast.error("Erro na transação", { autoClose: 3000 });
                    })
                    .finally(() => {
                        this.loadPayment = false;
                    })

            } else {
                console.log(response)
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
                document.getElementById('installments').options.length = 0;
                response[0].payer_costs.forEach(payerCost => {
                    let opt = document.createElement('option');
                    opt.text = payerCost.recommended_message;
                    opt.value = payerCost.installments;
                    document.getElementById('installments').appendChild(opt);
                });
            } else {
                alert(`installments method info error: ${response}`);
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
        }
    },
    watch: {
        selectedPaymentType() {
            if (this.selectedPaymentType == 'credit_card') {
                // this.initMpForm();
            }
        },

        cardnumber() {
            let val = this.cardnumber.replace(/\s/g, '');
            if (val.length >= 7) {
                window.Mercadopago.getPaymentMethod({
                    "bin": val.substring(0, 6)
                }, this.setPaymentMethod);
            }

            if(val.length == 16) {
                this.getInstallments()
            }
        },

        expiration() {
            if (this.expiration.includes('/')) {
                const exp = this.expiration.split('/');
                this.card_expiration.expirationMonth = exp[0];
                this.card_expiration.expirationMonth = exp[1];
            }
        }
    }
}
</script>