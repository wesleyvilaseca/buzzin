<template>
    <header>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-vuefood">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <span v-if="preloader" class="text-center">
                        <img src="../../../../assets/imgs/preloader.gif" alt="Carregando..." style="max-width: 35px;" />
                    </span>
                    <span v-else>
                        <img :src="company.logo" alt="VueFood" class="logo" />
                    </span>
                </a>
                <div>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item nav-cart">
                            <a href="/app/cart" class="nav-link" style="color: #fff">
                                <i class="fa-solid fa-cart-shopping"></i> {{ productsCart.length }}
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="#" class="nav-link mt-2 ms-5" style="color:#4060ff" v-if="me.name">Olá {{ me.name }}
                                <span @click.prevent="exit()" class="text-danger ms-2">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </span>
                            </a>
                            <a href="/app/login" class="nav-link mt-2 ms-5" style="color:#4060ff" v-else>
                                Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>


  
<script>
import { mapState, mapActions } from "vuex";

export default {
    computed: {
        ...mapState({
            company: (state) => state.tenant.company,
            productsCart: (state) => state.cart.products.data,
            preloader: (state) => state.preloader.preloader,
            me: (state) => state.auth.me
        }),
    },
    methods: {
        ...mapActions([
            "getTenant",
            "getCart",
            "getLayout",
            "getMe"
        ]),

        exit() {
            console.log('sair');
        },
    },
    mounted() {
        this.getTenant();
        this.getLayout();
        this.getMe()
    },
    watch: {
        company() {
            this.getCart(this.company.uuid);
        }
    },
};
</script>