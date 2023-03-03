<template>
    <DefaultLayout>
        <template v-slot:content>
            <div>
                <div class="container">
                    <div class="row">
                        <div class="list-categories">
                            <a href="#" @click.prevent="filterByCategory(category)"
                                v-for="(category, index) in categories.data" :key="index"
                                :class="['list-categories__item', categoryInFilter(category)]">
                                <div class="icon">
                                    <img class="card-img-top" :src="category.image" :alt="category.name" />
                                </div>
                                <span> {{ category.name }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Cards Produtos -->
                <div class="container">
                    <div class="row my-4">
                        <div v-if="products.data.length === 0">Nenhum produto</div>

                        <div class="col-lg-3 col-md-6 mb-4" v-for="(product, index) in products.data" :key="index">
                            <div :class="['card--flat', 'h-100']">
                                <a href="#">
                                    <div class="card-image">
                                        <img class="card-img-top" :src="product.image" alt="" />
                                    </div>
                                </a>
                                <div class="card-body">
                                    <h4 class="card-title">
                                        <a href="#">{{ product.name }}</a>
                                    </h4>
                                    <h5>R$ {{ product.price | formatPrice }}</h5>
                                    <p class="card-text">{{ product.description }}</p>
                                </div>

                                <div :class="['card-footer', 'card-footer-custom']" style="color: #fff"
                                    @click.prevent="addProductCart(product)">
                                    <span>
                                        <i class="fas fa-cart-plus"></i> Adicionar
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </template>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from '../../layouts/tenant_site/DefaultLayout.vue';
import { mapActions, mapState, mapMutations, mapGetters } from "vuex";

export default {
    props: [],
    components: {
        DefaultLayout
    },
    data: () => ({}),
    computed: {
        ...mapState({
            products: (state) => state.products.products,
            categories: (state) => state.categories.categories,
        }),
    },
    methods: {
        ...mapActions([
            "getProducts",
            "getCategories"
        ]),

        addProductCart(item) {

        },

        filterByCategory(category) {

        },

        categoryInFilter(category) {

        }
    },
    mounted() {
        this.getProducts();
        this.getCategories()
    },
}
</script>