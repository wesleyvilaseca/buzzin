<template>
    <div class="form-group">
        <input type="text" id="cep" class="form-control" v-model="cartCep" placeholder="Informe o CEP de entrega"
            v-mask="'#####-###'" v-if="!selectedAddress.zip_code" />
    </div>
    <div class="d-flex justify-content-left" v-if="!selectedAddress.zip_code">
        <div class="">
            <template v-if="loading">
                <i class="fas fa-spinner fa-spin"></i> Buscando...
            </template>

            <template v-else>
                <div class="alert alert-danger mt-2" v-if="errorMessage">
                    {{ errorMessage }} :(
                </div>

                <template v-if="shippingMethods.data.length > 0">
                    <ul class="list-group list-group-flush mt-2">
                        <li class="list-group-item list-group-item-success" v-for="(method, index) in shippingMethods.data"
                            :key="index">
                            {{ method.description }} : <strong>R$ {{ method.price }}</strong>
                            <template v-if="method.estimation">
                                <ul class="ps-2">
                                    <li>Bairro: <strong>{{ method.estimation.location }}</strong><br />
                                        <span>
                                            Tempo estimado: <strong>
                                                de {{ method.estimation.time_ini }}
                                                a {{ method.estimation.time_end }} {{
                                                    method.estimation.time_unid }}
                                            </strong>
                                        </span>
                                    </li>
                                </ul>
                            </template>
                        </li>
                    </ul>
                    <template v-if="shippingMethods.data[index++]">
                        <hr>
                    </template>
                </template>
            </template>
        </div>
    </div>
</template>

<script>
import { mapState, mapActions, mapMutations } from "vuex";

export default {
    props: [],
    components: {},
    data() {
        return {
            errorMessage: "",
            cartCep: "",
            loading: false,
        }
    },
    computed: {
        ...mapState({
            selectedAddress: (state) => state.cart.selectedAddress,
            shippingMethods: (state) => state.cart.shippingMethods,
            total: (state) => state.cart.total
        }),
    },
    mounted() { },
    methods: {
        ...mapActions(["shippingValue"]),
        getShippingValue(cep) {
            this.errorMessage = "";
            const params = {
                "cep": cep.replace("-", ""),
                "cartPrice": this.total
            }
            return this.shippingValue(params)
        },
    },
    watch: {
        cartCep() {
            if (this.cartCep.length === 9) {
                this.errorMessage = "";
                this.loading = true;
                this.getShippingValue(this.cartCep)
                    .catch((error) => {
                        if (error?.response?.data?.message) {
                            this.errorMessage = error.response.data.message;
                        }
                    })
                    .finally(() => this.loading = false);
            }
        },
    },
}
</script>