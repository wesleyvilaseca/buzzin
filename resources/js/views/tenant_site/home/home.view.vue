<template>
    <DefaultLayout>
        <template v-slot:content>
            <div class="container">
                <Carousel :settings="settings" :breakpoints="breakpoints">
                    <Slide v-for="(category, index) in categories.data" :key="index" class="list-categories">
                        <a class="carousel__item list-categories__item" href="#"
                            :class="['list-categories__item', categoryInFilter(category)]"
                            @click.prevent="filterByCategory(category)">
                            <div class="icon">
                                <img class="card-img-top" :src="category.image" :alt="category.name" />
                            </div>
                            <span> {{ category.name }}</span>
                        </a>
                    </Slide>

                    <template #addons>
                        <Navigation />
                    </template>
                </Carousel>
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
        </template>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from '../../layouts/tenant_site/DefaultLayout.vue';
import { mapActions, mapState, mapMutations, mapGetters } from "vuex";

import 'vue3-carousel/dist/carousel.css';
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'

export default {
    props: [],
    components: {
        DefaultLayout,
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
    data: () => ({
        filters: {
            category: ""
        },
        settings: {
            itemsToShow: 1,
            snapAlign: 'center',
        },
        breakpoints: {
            700: {
                itemsToShow: 3.5,
                snapAlign: 'center',
            },
            1024: {
                itemsToShow: 7,
                snapAlign: 'start',
            },
        },
    }),
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
            console.log(item);
        },

        filterByCategory(category) {
            if (category.id === this.filters.category) {
                this.filters.category = "";
            } else {
                this.filters.category = category.id;
            }

            var params = {};
            if (this.filters.category) {
                params.categories = [this.filters.category];
            }

            this.getProducts(params);
        },

        categoryInFilter(category) {
            return category.id == this.filters.category ? "active-category" : "";
        }
    },
    mounted() {
        this.getProducts();
        this.getCategories()
    },
}
</script>