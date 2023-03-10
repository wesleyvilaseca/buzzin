<template>
    <div>
        <div class="d-flex justify-content-between">
            <div class="cep">
                <div class="form-group">
                    <input type="text" id="cep" class="form-control" v-model="cartCep"
                        placeholder="Informe o CEP de entrega" v-mask="'#####-###'" />
                </div>
            </div>
            <div class="text-right">
                <div class="cart-price text-red">
                    Preço Total: <b>R$ {{ total }}</b>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-left">
            <div class="">
                <template v-if="loading">
                    <i class="fas fa-spinner fa-spin"></i> Buscando...
                </template>

                <template v-else>
                    <div class="alert alert-danger mt-2" v-if="errorMessage">
                        {{ errorMessage }} :(
                    </div>

                    <template v-if="shippingMethods.length > 0">
                        <ul class="list-group list-group-flush mt-2">
                            <li class="list-group-item list-group-item-success" v-for="(method, index) in shippingMethods" :key="index">
                                {{ method.description }} : <strong>R$ {{ method.price }}</strong>
                                <template v-if="method.estimation">
                                    <ul class="ps-2">
                                        <li>Bairro: <strong>{{ method.estimation.location }}</strong><br />
                                            <span>
                                                Tempo estimado: <strong>
                                                    de {{ method.estimation.time_ini }}
                                                    a {{ method.estimation.time_end }} {{ method.estimation.time_unid }}
                                                </strong>
                                            </span>
                                        </li>
                                    </ul>
                                </template>
                            </li>
                        </ul>
                        <template v-if="shippingMethods[index++]">
                            <hr>
                        </template>
                    </template>
                </template>
            </div>
        </div>

        <div class="mt-4">
            <a href="" class="cart-finalizar" @click.prevent="openModalCheckout()">Finalizar</a>
        </div>

        <ModalComponent v-show="isModalVisible" title="Pedido" @close="closeModal">
            <template v-slot:content>

                <div name="checkout-order" :heigth="350">
                    <div class="px-md-5 my-4" v-if="loading">
                        <p>Gerando o pedido... (aguarde!)</p>
                    </div>
                    <div class="px-md-5 my-4" v-else>
                        <div class="col-12" v-if="me.name == ''">
                            <div class="">
                                <div class="alert alert-warning">
                                    Para finalizar o pedido você precisa estar logado
                                </div>
                                <p><strong>Total de produtos: </strong>{{ products.length }}</p>
                                <p><strong>Preço total: </strong> R$ {{ total }}</p>
                                <div class="text-center d-grid gap-2 d-md-block">
                                    <a href="/app/login" type="button" class="btn load_more_btn" style="width: 200px;">
                                        Login
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </ModalComponent>
    </div>
</template>
  
<script>
import ModalComponent from "../../../../components/widgets/ModalComponent.vue";
import { mapState, mapActions } from "vuex";
export default {
    components: {
        ModalComponent
    },
    data() {
        return {
            cartCep: "",
            isModalVisible: false,
            loading: false,
            hasDelivery: "",
            comment: "",
            errorMessage: "",
            shippingMethods: []
        };
    },
    computed: {
        ...mapState({
            products: (state) => state.cart.products.data,
            total: (state) => state.cart.total,
            company: (state) => state.tenant.company,
            me: (state) => state.auth.me,
        })
    },
    methods: {
        ...mapActions(["shippingValue"]),
        createOrder() {
            // this.loading = true;
            // const action = this.me.name === "" ? "create_order" : "create_order_auth";
            // let params = {
            //     token_company: this.company.uuid,
            //     comment: this.comment,
            //     products: [...this.products],
            // };
            // this.$store
            //     .dispatch(action, params)
            //     .then((res) => {
            //         this.$vToastify.success("Pedido realizado com sucesso", "Parabéns");
            //         this.$router.push({
            //             name: "detail.order",
            //             params: { identify: res.identify },
            //         });
            //     })
            //     .catch((res) => {
            //         this.$vToastify.error(
            //             "Falha ao realizar o pedido, tente mais tarde :(",
            //             "Erro"
            //         );
            //     })
            //     .finally((res) => {
            //         this.loading = false;
            //     });
        },
        openModalCheckout() {
            if (this.me.name !== '') {
                return window.location.href = `http://${this.company.subdomain}/app/checkout`;
            }

            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        },
    },
    watch: {
        cartCep() {
            if (this.cartCep.length === 9) {
                this.errorMessage = "";
                this.shippingMethods = [];
                this.loading = true;

                const params = {
                    "cep": this.cartCep.replace("-", ""),
                    "cartPrice": this.total
                }
                this.shippingValue(params)
                    .then((res) => {
                        this.shippingMethods = res.data;
                    })
                    .catch((error) => {
                        if (error?.response?.data?.message) {
                            this.errorMessage = error.response.data.message;
                        }
                    })
                    .finally(() => this.loading = false);
                return;
            }
        }
    },
};
</script>