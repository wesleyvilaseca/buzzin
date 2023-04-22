<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Produto</th>
                <th scope="col">Quantidade</th>
                <th scope="col">Valor</th>
                <th scope="col">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(product, index) in products" :key="index">
                <td>{{ product.item.description }}</td>
                <td>{{ moneyMask(product.item.price) }}</td>
                <td>{{ product.qty }}</td>
                <td>{{ moneyMask(product.qty * product.item.price) }}</td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3" class="text-right">
                    <strong>Subtotal</strong>
                </td>
                <td> {{ moneyMask(subtotal) }}</td>
            </tr>

            <tr>
                <td colspan="3" class="text-right">
                    <strong>
                        {{ selectedShippingMethod.description }}
                    </strong>
                </td>
                <td> {{ moneyMask(selectedShippingMethod.price) }}</td>
            </tr>

            <tr>
                <td colspan="3" class="text-right">
                    <strong>
                        Total
                    </strong>
                </td>
                <td> {{ moneyMask(total) }}</td>
            </tr>

            <tr>
                <td colspan="2">
                    Forma de pagamento: {{ selectedPaymentMethod.description }}
                </td>
            </tr>

            <tr>
                <td colspan="2" v-if="selectedPaymentMethod.tag == 'pagar-em-dinheiro' && troco > 0">
                    Troco para: {{ moneyMask(troco) }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="text-right mt-2">
        <button class="btn btn-success btn-sm" @click.prevent="createOrder()">Finalizar pedido</button>
    </div>
</template>

<script>
import { mapState, mapActions, mapMutations } from "vuex";
import { toast } from 'vue3-toastify';

export default {
    props: [],
    components: {},
    data: () => ({}),
    computed: {
        ...mapState({
            step: (state) => state.cart.step,
            products: (state) => state.cart.products.data,
            subtotal: (state) => state.cart.subtotal,
            total: (state) => state.cart.total,
            company: (state) => state.tenant.company,
            me: (state) => state.auth.me,
            address: (state) => state.auth.address,
            selectedAddress: (state) => state.cart.selectedAddress,
            selectedShippingMethod: (state) => state.cart.selectedShippingMethod,
            selectedPaymentMethod: (state) => state.cart.selectedPaymentMethod,
            troco: (state) => state.cart.troco,
            precisa_troco: (state) => state.cart.precisa_troco,
            comment: (state) => state.cart.comment
        }),
    },
    mounted() { },
    methods: {
        ...mapMutations({
            clearCart: "CLEAR_CART",
        }),
        ...mapActions(["sendCheckout"]),
        createOrder() {
            const params = {
                address: this.selectedAddress,
                products: this.products,
                shippingMethod: this.selectedShippingMethod,
                comment: this.comment,
                paymentMethod: this.selectedPaymentMethod,
                precisaTroco: this.precisa_troco ? "Y" : "N",
                troco: this.troco ? this.troco : 0
            }
            this.sendCheckout(params)
                .then((res) => {
                    toast.success("Pedido realizado com sucesso", { autoClose: 3000 });
                    this.clearCart(this.company.uuid);
                    window.location.href = `http://${this.company.subdomain}/app/cliente-area`;
                })
                .catch((error) => {
                    toast.error(
                        "Falha na operação, tente novamente",
                        { autoClose: 5000 }
                    );
                })
        },
        moneyMask(value) {
            if (typeof value !== "number") {
                return value;
            }
            var formatter = new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            });
            return formatter.format(value);
        }
    }
}
</script>