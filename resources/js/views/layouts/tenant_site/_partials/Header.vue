<template>
    <header>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-vuefood">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <img :src="company.logo" alt="VueFood" class="logo" />
                </a>
                <div>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item nav-cart">
                            <a href="#" class="nav-link" style="color: #fff">
                                <i class="fa-solid fa-cart-shopping"></i> 0
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link mt-2 ms-5" style="color:#4060ff">
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
        }),
    },
    methods: {
        ...mapActions([
            "getTenant",
        ]),

        exit() {
            console.log('sair');
        },
    },
    mounted() {
        this.getTenant();
    },
};
</script>