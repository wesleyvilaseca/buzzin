<template>
    <template v-if="selectedPaymentMethod?.integration == 'MercadoPago'">
        <MercadoPago />
    </template>
</template>

<script>
import { mapState } from "vuex";
import MercadoPago from "../integrations.checkout/MercadoPago/MercadoPago.vue";

export default {
    props: [],
    components: {
        MercadoPago
    },
    data: () => ({ }),
    computed: {
        ...mapState({
            selectedPaymentMethod: (state) => state.cart.selectedPaymentMethod
        }),
    },
    mounted() { },
    methods: { }
}
</script>