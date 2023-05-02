<template>
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

    <template v-else>
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
</template>


<script>
import ModalComponent from '../../../../../components/widgets/ModalComponent.vue';
import { mapState, mapActions, mapMutations } from "vuex";
import { toast } from 'vue3-toastify';

export default {
    components: {
        ModalComponent,
    },
    data: () => ({
        loading: false,
        errorMessage: ""
    }),
    computed: {
        ...mapState({
            address: (state) => state.auth.address,
            company: (state) => state.tenant.company,
            shippingMethods: (state) => state.cart.shippingMethods,
            selectedShippingMethod: (state) => state.cart.selectedShippingMethod,
            selectedAddress: (state) => state.cart.selectedAddress,
        }),
    },
    methods: {
        ...mapActions(["getPaymentMethods"]),
        ...mapMutations({
            setSelectedShippingMethod: "SET_SELECTED_SHIPPING_METHOD",
            setSelectedPaymentMethod: "SET_SELECTED_PAYMENT_METHOD",
            setPaymentMethods: "SET_PAYMENT_METHODS",
            setShippingPriceToTotal: "SET_SHIPPING_VALUE_TO_TOTAL_CART",
            setStep: "SET_STEP"
        }),

        setShippingSelected(item) {
            this.setSelectedShippingMethod(item);
            this.setShippingPriceToTotal(this.selectedShippingMethod?.price);

            //clear payment methods
            this.setSelectedPaymentMethod({ description: "" });
            this.setPaymentMethods([]);

            if (this.selectedAddress.zip_code !== "" && this.selectedShippingMethod.price !== "") {
                this.loading = true
                this.getPaymentMethods({ selectedShippingMethod: this.selectedShippingMethod })
                    .then(() => {
                        this.setStep(2)
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                    .finally(() => this.loading = false)
            }
        },
    },
    watch: {
        shippingMethods() {
            if (this.selectedAddress.zip_code && this.shippingMethods.data.length <= 0) {
                this.errorMessage = "Não há metodos de entrega disponível"
            }
        }
    }
}
</script>