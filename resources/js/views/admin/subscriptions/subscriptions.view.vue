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
                                <h5 class="fw-bold">{{ plan.name }}</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="inner-content position-relative">
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
                                <div class="option ps-3 hover-zoom" @click.prevent="setSelectedPaymentMethod('slip')">
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
                            <div class="">
                                <h5 class="fw-bold">{{ titlePayment }}</h5>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="" v-if="hasSelectedPlan">
                                <span class="badge bg-dark text-light" @click.prevent="setSelectedPaymentMethod('')"
                                    style="cursor:pointer">
                                    <i class="fa-solid fa-chevron-left"></i>
                                    Mudar
                                </span>
                            </div>

                            <div v-if="selectedPaymentType == 'credit_card'">
                                <formCreditVue :tenant="tenant" :plan="selectPlan" />
                            </div>

                            <div v-if="selectedPaymentType == 'slip'">
                                <formSlip :tenant="tenant" :plan="selectPlan" />
                            </div>
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
import formCreditVue from "./_partials/form.credit.vue";
import formSlip from "./_partials/form.boleto.vue";

export default {
    props: {
        tenant: Object
    },
    components: {
        PreloaderComponent,
        formCreditVue,
        formSlip
    },
    created() { },
    mounted() {
        this.getPlans()
    },
    data() {
        return {
            selectedPlan: {},
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
            },
            showstallmants: false
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
            this.selectPlan = plan;
            this.hasSelectedPlan = true;
            this.listPlans.data = [plan];
        },
        unSelectPlan() {
            this.selectPlan = {};
            this.showstallmants = false;
            this.selectedPaymentType = "";
            this.hasSelectedPlan = false;
            this.listPlans.data = this.plans.data;
        },
        setSelectedPaymentMethod(val) {
            this.selectedPaymentType = val;
        }
    },
    watch: {}
}
</script>