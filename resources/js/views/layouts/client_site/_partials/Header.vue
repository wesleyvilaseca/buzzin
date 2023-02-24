<template>
    <header>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-vuefood">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <img src="../../../../assets/imgs/logo-vuefood.png" alt="VueFood" class="logo" />
                </a>
                <div>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item nav-cart">
                            <a href="#" class="nav-link" style="color: #fff">
                                <i class="fa-solid fa-cart-shopping"></i> 0
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link text-success mt-2 ms-5">
                                Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</template>

<style scoped>
@import url('../../../../assets/css/reset.css');
@import url('../../../../assets/css/vuefood.css');
@import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css");
</style>
  
<script>
import { mapActions, mapState } from "vuex";
export default {
    computed: {},
    methods: {
        exit() {
            console.log('sair');
        },
    },
};
</script>