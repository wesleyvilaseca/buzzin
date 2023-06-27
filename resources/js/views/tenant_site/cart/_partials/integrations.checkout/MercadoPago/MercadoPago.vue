<template>
    <div class="card mb-2">
        <div class="card-header text-center">Resumo do pedido</div>
        <div class="card-body">
            <ResumeOrderStepComponent :showDefaultCreateOrderBtn="false" />
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-header text-center" style="background-color: #fff;">
                    <h5 class="fw-bold">Como você prefere pagar?</h5>
                </div>
                <div class="card-body">
                    <div class="payment-options">
                        <template v-if="!paymentIntegrationMethodSelected.id">
                            <div class="option ps-3 hover-zoom" v-for="(item, index) in paymentsMethods" :key="index"
                                @click.prevent="setSelectedPaymentMethod(item)">
                                <div class="row">
                                    <div class="col-md-2">
                                        <span style="font-size: 50px;">
                                            <i :class="item.icon"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-8 mt-1">
                                        <h6>{{ item.title }}</h6>
                                        <p class="text-muted">
                                            {{ item.description }}
                                        </p>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </template>
                        <template v-else>
                            <div class="option ps-3 hover-zoom">
                                <div class="row">
                                    <div class="col-md-2">
                                        <span style="font-size: 50px;">
                                            <i :class="paymentIntegrationMethodSelected.icon"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-8 mt-1">
                                        <h6>{{ paymentIntegrationMethodSelected.title }}</h6>
                                        <p class="text-muted">
                                            {{ paymentIntegrationMethodSelected.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12" v-if="paymentIntegrationMethodSelected.id">
            <div class="card">
                <div class="card-header text-center" style="background-color: #fff;">
                    <div class="">
                        <h5 class="fw-bold">{{ paymentIntegrationMethodSelected.title }}</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="" v-if="paymentIntegrationMethodSelected.id">
                        <span class="badge bg-dark text-light" @click.prevent="setSelectedPaymentMethod('')"
                            style="cursor:pointer">
                            <i class="fa-solid fa-chevron-left"></i>
                            Mudar
                        </span>
                    </div>

                    <div
                        v-if="paymentIntegrationMethodSelected.id && paymentIntegrationMethodSelected?.flag == 'credit_card'">
                        <formCreditcard />
                    </div>

                    <div v-if="paymentIntegrationMethodSelected.id && paymentIntegrationMethodSelected?.flag == 'slip'">
                        <formSlip />
                    </div>

                    <!-- <div v-if="paymentIntegrationMethodSelected == 'pix'">
                        <formPix />
                    </div> -->
                </div>
            </div>
        </div>
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
</style>

<script>
import { mapState, mapActions, mapMutations } from "vuex";
import ResumeOrderStepComponent from '../../steps.checkout/resumeOrder.vue';
import formCreditcard from './_partials/form.creditcard.vue';
import formSlip from './_partials/form.slip.vue';

export default {
    props: [],
    components: {
        formCreditcard,
        formSlip,
        ResumeOrderStepComponent
    },
    data: () => ({
        paymentIntegrationMethodSelected: {
            id: ""
        },
        paymentsMethods: [
            {
                id: 1,
                title: 'Cartão',
                description: 'Crédito ou Débito',
                icon: 'fa-solid fa-credit-card',
                flag: 'credit_card'
            },
            {
                id: 2,
                title: 'Boleto bancário',
                description: ' Pagamento aprovado em 1 ou 2 dias uteis',
                icon: 'fa-solid fa-barcode',
                flag: 'slip'
            },
            // {
            //     id: 3,
            //     title: 'Pix',
            //     description: 'Aprovação imediata',
            //     icon: 'fa-brands fa-pix',
            //     flag: 'pix'
            // }
        ]
    }),
    computed: {
        ...mapState({
            selectedPaymentMethod: (state) => state.cart.selectedPaymentMethod,
        }),
        mpConfig() {
            return JSON.parse(this.selectedPaymentMethod.data);
        }
    },
    created() {
        if (!this.mpConfig.card) {
            this.removeItemFromArray(1);
        }

        if(!this.mpConfig.slip){
            this.removeItemFromArray(2);
        }
    },
    methods: {
        setSelectedPaymentMethod(method) {
            this.paymentIntegrationMethodSelected = method;
        },

        removeItemFromArray(id) {
            var indiceDoObjeto = this.paymentsMethods.findIndex(function (obj) {
                return obj.id === id;
            });

            if (indiceDoObjeto !== -1) {
                this.paymentsMethods.splice(indiceDoObjeto, 1);
            }
        }
    }
}
</script>