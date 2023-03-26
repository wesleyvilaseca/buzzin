<template>
    <DefaultLayout>
        <template v-slot:content>
            <div class="container pt-5 pb-3" v-if="me.name !== ''">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                            type="button" role="tab" aria-controls="home" aria-selected="true">
                            <i class="fa-solid fa-cart-shopping"></i>
                            Meus Pedidos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">
                            <i class="fa-solid fa-house"></i>
                            Meus endereços
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact"
                            type="button" role="tab" aria-controls="contact" aria-selected="false">
                            <i class="fa-solid fa-user"></i>
                            Minha conta
                        </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <OrdersView />
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <AddressesView />
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">

                    </div>
                </div>
            </div>
        </template>
    </DefaultLayout>
</template>

<style> .modal {
     background-color: rgba(0, 0, 0, 0.6) !important;
 }
</style>


<script>
import { mapState, mapActions } from "vuex";
import DefaultLayout from '../../layouts/tenant_site/DefaultLayout.vue';
import OrdersView from "./orders/orders.view.vue";
import AddressesView from "./addresses/addresses.view.vue";

export default {
    props: [],
    components: {
        DefaultLayout,
        OrdersView,
        AddressesView
    },
    data: () => ({}),
    computed: {
        ...mapState({
            me: (state) => state.auth.me,
        }),
    },
    created() {
        this.getMe()
            .then(() => {
                if (this.me.name == '') {
                    window.location.href = `/`;
                }
            })
    },
    methods: {
        ...mapActions([
            "getMe",
        ]),
    },
    watch: {},

}
</script>