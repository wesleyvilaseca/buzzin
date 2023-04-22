<template>
    <template v-if="paymentMethods.data.length > 0">
        <div class="mt-3">
            <div class="form-check" v-for="(method, index) in paymentMethods.data" :key="index">
                <input class="form-check-input" name="paymentMethod" type="radio" :id="`radio${method.tag}`"
                    @change.prevent="setPaymentMethodSelected(method)">
                <label class="form-check-label" :for="`radio${method.tag}`">
                    {{ method.description }}
                </label>
            </div>
        </div>

        <div class="mt-2 mb-2">
            <label for="exampleFormControlTextarea1" class="form-label">Deseja fazer algum comentário
                para o lojista?
            </label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" v-model="comment"></textarea>
        </div>
    </template>
    <template v-else>
        <div class="alert alent-warning text-center">
            Não há metodos de pagamento disponível
        </div>
    </template>

    <template v-if="loading">
        <div class="text-center mt-2">
            <i class="fas fa-spinner fa-spin"></i> Buscando...
        </div>
    </template>

    <template v-if="paymentSelected?.tag == 'pagar-em-dinheiro'">
        <button type="button" class="btn load_more_btn mt-2" @click.prevent="openModalTroco(true)">
            <span>Informar o troco</span>
        </button>
    </template>

    <ModalComponent v-show="isModalTrocoVisible" :modalSize="'modal-lg'" title="Troco"
        @close="setPaymentMethodSelected(paymentSelected)">
        <template v-slot:content>
            <div name="checkout-order" :heigth="350">
                <div class="form-text text-danger" v-if="errors.troco != ''">
                    {{ errors.troco[0] || "" }}
                </div>
                <table class="table">
                    <tbody class="font-weight-normal">
                        <tr>
                            <td>Valor do pedido: </td>
                            <td>R$ {{ subtotal }}</td>
                        </tr>
                        <tr>
                            <td>Valor do frete:</td>
                            <td>R$ {{ selectedShippingMethod.price }}</td>
                        </tr>

                        <tr>
                            <td>Valor total do pedido:</td>
                            <td>R$ {{ total }}</td>
                        </tr>
                    </tbody>
                </table>

                <div>
                    <label for="exampleInputEmail1" class="form-label">Precisa de troco?</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1"
                            @change.prevent="setPrecisaTroco(true)">
                        <label class="form-check-label" for="inlineRadio1">Sim</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2"
                            @change.prevent="setPrecisaTroco(false)">
                        <label class="form-check-label" for="inlineRadio2">Não</label>
                    </div>
                </div>

                <div class="form-group mt-2" v-if="precisa_troco !== 'undefined' && precisa_troco == true">
                    <label>Troco pra quanto?</label>
                    <money3 v-model="troco" v-bind="config" class="form-control form-control-sm currency"
                        placeholder="50" />
                </div>

                <button type="button" class="btn load_more_btn mt-2"
                    @click.prevent="setPaymentMethodSelected(paymentSelected)" v-if="precisa_troco !== 'undefined'">
                    <span>Ok</span>
                </button>
            </div>
        </template>
    </ModalComponent>
</template>

<style scoped>
.load_more_btn {
    background: v-bind("paleta.btn_color") !important;
    color: v-bind("paleta.btn_color_letter") !important;
    border-radius: 25px !important;
}

.calcel-button {
    background: v-bind("paleta.btn_color_hover") !important;
    color: v-bind("paleta.btn_color_letter") !important;
    border-radius: 25px !important;
}

.load_more_btn:hover {
    background: v-bind("paleta.btn_color_hover") !important;
}
</style>

<script>
import ModalComponent from '../../../../../components/widgets/ModalComponent.vue';
import { Money3Component } from 'v-money3';
import { mapState, mapActions, mapMutations } from "vuex";

export default {
    props: [],
    components: {
        ModalComponent,
        money3: Money3Component,
    },
    data: () => ({
        config: {
            masked: false,
            prefix: '',
            suffix: '',
            thousands: ',',
            decimal: '.',
            precision: 2,
            disableNegative: false,
            disabled: false,
            min: null,
            max: null,
            allowBlank: false,
            minimumNumberOfCharacters: 0,
        },
        errors: {
            troco: ""
        },
        troco: null,
        precisaTroco: "undefined",
        paymentSelected: "",
        isModalTrocoVisible: false,
        loading: false,
        comment: ""
    }),
    computed: {
        ...mapState({
            step: (state) => state.cart.step,
            subtotal: (state) => state.cart.subtotal,
            total: (state) => state.cart.total,
            paymentMethods: (state) => state.cart.paymentMethods,
            selectedPaymentMethod: (state) => state.cart.selectedPaymentMethod,
            precisa_troco: (state) => state.cart.precisa_troco,
            selectedShippingMethod: (state) => state.cart.selectedShippingMethod,
            paleta: (state) => state.layout.paleta,
        }),

    },
    mounted() { },
    methods: {
        ...mapMutations({
            setSelectedPaymentMethod: "SET_SELECTED_PAYMENT_METHOD",
            setStep: "SET_STEP",
            setTroco: "SET_TROCO",
            setPrecisaTroco: "SET_PRECISA_TROCO",
            setComment: "SET_COMMENT"
        }),

        openModalTroco(state) {
            this.isModalTrocoVisible = state;
        },

        setPaymentMethodSelected(item) {
            this.paymentSelected = item;
            this.setSelectedPaymentMethod({ description: "" });

            if (this.paymentSelected.tag == "pagar-em-dinheiro") {
                if (this.precisa_troco == "undefined") {
                    return this.openModalTroco(true);
                }

                if (this.precisa_troco) {
                    this.setStep(2);
                    if (this.troco == null) {
                        this.errors.troco = ["Informa o valor para troco"];
                        this.openModalTroco(true);
                        return;
                    }

                    if (this.troco) {
                        console.log(this.troco, this.total)
                        if (this.troco < this.total) {
                            this.errors.troco = ["O valor do troco não deve ser menor que o valor total do pedido"]
                            this.openModalTroco(true);
                            return;
                        }
                    }
                }
            } else {
                this.setPrecisaTroco("undefined");
                var radio = document.querySelector('input[type=radio][name=inlineRadioOptions]:checked');
                if (radio) {
                    radio.checked = false;
                }
            }

            this.setComment(this.comment);
            this.openModalTroco(false);
            this.setSelectedPaymentMethod(item);
            this.setTroco(this.troco);
            this.setStep(3);
        },
    }
}
</script>