<template>
    <div>
        <div class="text-center">
            <div class="alert alert-success mt-2 pb-3" v-if="shippingPrice">
                O valor da entrega: $ {{ shippingPrice }}
            </div>
            <div class="alert alert-danger" v-if="showDontShipping">
                No momento não estamos entregando para sua região
            </div>
        </div>
        
        <div class="d-flex justify-content-between">
            <div class="cep">
                <div class="form-group">
                    <input type="text" id="cep" class="form-control" v-model="cartCep"
                        placeholder="Informe o CEP de entrega" v-mask="'#####-###'" />
                </div>
            </div>

            <div class="text-right">
                <div class="cart-price text-red mb-5">
                    Preço Total: <b>R$ {{ total }}</b>
                </div>
            </div>
        </div>
        <a href="" class="cart-finalizar" @click.prevent="openModalCheckout()">Finalizar</a>

        <ModalComponent v-show="isModalVisible" title="Pedido" @close="closeModal">
            <template v-slot:content>

                <div name="checkout-order" :heigth="350">
                    <div class="px-md-5 my-4" v-if="loading">
                        <p>Gerando o pedido... (aguarde!)</p>
                    </div>
                    <div class="px-md-5 my-4" v-else>
                        <div class="col-12" v-if="me.name !== ''">
                            <p><strong>Total de produtos: </strong>{{ products.length }}</p>
                            <p><strong>Preço total: </strong> R$ {{ total }}</p>

                            <div class="form-group">
                                <textarea class="form-control my-4" name="comment" id="" cols="30" rows="3"
                                    placeholder="Comentario (opicional)" v-model="comment"></textarea>
                            </div>

                            <div class="text-center my-4">
                                <button class="btn btn-sm btn-info" @click.prevent="createOrder()">
                                    Fazer pedido
                                </button>
                            </div>
                        </div>

                        <div v-else class="row">
                            <div class="">
                                <div class="alert alert-warning">
                                    Para finalizar o pedido você precisa estar logado
                                </div>
                                <p><strong>Total de produtos: </strong>{{ products.length }}</p>
                                <p><strong>Preço total: </strong> R$ {{ total }}</p>

                                <!-- <div class="form-group">
                                    <textarea class="form-control my-4" name="comment" id="" cols="30" rows="3"
                                        placeholder="Comentario (opicional)" v-model="comment"></textarea>
                                </div> -->
                                <!-- <div class="text-center my-4">
                                    <button class="btn btn-sm btn-info" @click.prevent="createOrder()">
                                        Fazer pedido de forma anônima
                                    </button>
                                </div> -->
                                <div class="text-center d-grid gap-2 d-md-block">
                                    <a href="/app/login" type="button" class="btn load_more_btn" style="width: 200px;">
                                        Login
                                    </a>
                                </div>
                            </div>
                            <!-- <div class="col-6">
                                <a href="/app/login" class="btn btn-default btn-full">Fazer login</a>
                            </div> -->
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
            shippingPrice: "",
            showDontShipping: false,
            cartCep: "",
            isModalVisible: false,
            comment: "",
            loading: false,
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
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
        },
    },
    watch: {
        cartCep() {
            if (this.cartCep.length === 9) {
                this.shippingValue(this.cartCep)
                    .then((res) => {
                        if (res.shipping) {
                            this.shippingPrice = res.price;
                            this.showDontShipping = false;
                            return;
                        }

                        this.shippingPrice = "";
                        this.showDontShipping = true;
                    })
                return;
            }
        }
    },
};
</script>