<template>
    <header>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-vuefood pt-2">
            <div class="container">
                <Link href="/" class="navbar-brand" v-if="!maintence">
                <span v-if="preloader" class="text-center">
                    <img src="../../../../assets/imgs/preloader.gif" alt="Carregando..." style="max-width: 35px;" />
                </span>
                <span v-else>
                    <img :src="company.logo" alt="BuzzIn" class="logo" />
                </span>
                </Link>

                <Link href="/" class="navbar-brand" v-else>
                <img src="../../../../assets/imgs/404.png" alt="Em manutenção" style="max-width: 35px;" />
                </Link>

                <div v-if="!maintence">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item nav-cart">
                            <Link href="/app/cart" class="nav-link btn-nav">
                            <i class="white-icon fa-solid fa-cart-shopping"></i>
                            <span class="ms-1 white-icon"> {{ productsCart.length }}</span>
                            </Link>
                        </li>

                        <li class="nav-item">
                            <Link href="/app/cliente-area" class="nav-link ms-5" v-if="me.name && me.name !== 'undefined'">
                            Olá
                            {{ me.name
                            }}
                            <span @click.prevent="exit()" class="text-danger ms-2">
                                <i class="red-icon fa-solid fa-right-from-bracket"></i>
                            </span>
                            </Link>
                            <Link href="/app/login" class="nav-link ms-5" v-else>
                            Login
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>  

<style scoped>
.nav-cart {
    background: v-bind("paleta.btn_color") !important;
}


.nav-cart:hover {
    background: v-bind("paleta.btn_color_hover") !important;
}

.nav-link {
    color: v-bind("paleta.links") !important;
}

.nav-link:hover {
    color: v-bind("paleta.links_hover") !important;
}

.nav-link .white-icon {
    color: #fff !important;
}

.nav-link .red-icon {
    color: red !important;
}
</style>

<script>
import { mapState, mapActions } from "vuex";

export default {
    props: {},
    data() {
        return {
            title: '',
            meta: '',
            requested: false
        }
    },
    computed: {
        ...mapState({
            me: (state) => state.auth.me,
            company: (state) => state.tenant.company,
            productsCart: (state) => state.cart.products.data,
            preloader: (state) => state.preloader.preloader,
            maintence: (state) => state.maintence.maintence,
            paleta: (state) => state.layout.paleta
        }),
    },
    methods: {
        ...mapActions([
            "getMe",
            "getTenant",
            "getCart",
            "setPaleta",
            "logout",
            "getSiteExtensions"
        ]),

        exit() {
            this.logout()
                .then(() => {
                    window.location.href = `http://${this.company.domain}`;
                })
        },
    },
    mounted() {
        this.title = this.$page?.props?.title;
        this.meta = this.$page?.props?.meta;
        document.title = this.title ? this.title : 'BuzzIn!';

        if (this.meta) {
            var meta = document.createElement('meta');
            meta.name = this.meta.description;
            meta1.content = this.meta.content;
        }
    },
    created() {
        if (this.maintence) return;

        this.getMe();
        this.getTenant();
        this.setPaleta();
    },
    watch: {
        company() {
            if (this.maintence) return;

            if (this.company.uuid && !this.requested) {
                this.requested = true;
                this.getCart(this.company.uuid);
                this.getSiteExtensions({ uuid: this.company.uuid });
            }


        }
    },
};
</script>