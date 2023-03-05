<template>
    <div>
        <div class="cart-price text-red mb-5">
            Preço Total: <b>R$ {{ total }}</b>
        </div>
        <a href="" class="cart-finalizar" @click.prevent="openModalCheckout()">Finalizar</a>

        <ModalComponent v-show="isModalVisible" title="Che" @close="closeModal">
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
                            <div class="col-6">
                                <p><strong>Total de produtos: </strong>{{ products.length }}</p>
                                <p><strong>Preço total: </strong> R$ {{ total }}</p>

                                <div class="form-group">
                                    <textarea class="form-control my-4" name="comment" id="" cols="30" rows="3"
                                        placeholder="Comentario (opicional)" v-model="comment"></textarea>
                                </div>

                                <div class="text-center my-4">
                                    <button class="btn btn-sm btn-info" @click.prevent="createOrder()">
                                        Fazer pedido de forma anônima
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <a href="/app/login" class="btn btn-default btn-full">Fazer login</a>
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
        // ...mapActions(["create_order", "create_order_auth"]),
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
};
</script>