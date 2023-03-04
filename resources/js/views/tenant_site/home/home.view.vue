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
                    <div class="col-lg-3 col-md-6 col-sm-12 mb-4" v-for="(product, index) in products.data" :key="index">
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
                <div class="text-center d-grid gap-2 d-md-block" v-if="loadmore">
                    <button type="button" class="btn load_more_btn" @click.prevent="loaMoreProduts()" v-html="textButton"
                        :disabled="btnDisabled">
                    </button>
                </div>
            </div>
        </template>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from '../../layouts/tenant_site/DefaultLayout.vue';
import { mapActions, mapState, mapMutations, mapGetters } from "vuex";
import { toast } from 'vue3-toastify';

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
        btnDisabled: false,
        textButton: 'Carregar mais produtos',
        filters: {
            category: ""
        },
        settings: {
            itemsToShow: 2,
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
            preloader: (state) => state.preloader.preloader,
            loadmore: (state) => state.preloader.loadmore,
            paginate: (state) => state.paginate.meta,
            cart: (state) => state.cart.products,
            company: (state) => state.tenant.company,
        }),
    },
    methods: {
        ...mapActions([
            "getProducts",
            "getCategories",
            "setItemInCart",
            "incrementToCart",
            "getCart"
        ]),

        addProductCart(item) {
            if (this.checkIfIsInCart(item.identify)) {
                return this.incrementToCart({ uuid: this.company.uuid, product: item })
                    .then(() => {
                        toast.success("Produto adicionado ao carrinho", { autoClose: 2000 });
                    })
            }
            return this.setItemInCart({ product: item, uuid: this.company.uuid })
                .then(() => {
                    toast.success("Produto adicionado ao carrinho", { autoClose: 2000 });
                });
        },

        checkIfIsInCart(identify) {
            return this.cart.data.some((item) => {
                return item.identify == identify;
            });
        },

        filterByCategory(category) {
            if (category.id === this.filters.category) {
                this.filters.category = "";
            } else {
                this.filters.category = category.id;
            }

            var params = { page: "" };

            if (this.filters.category) {
                params.categories = [this.filters.category];
            }

            this.getProducts(params);
        },

        loaMoreProduts() {
            console.log(this.company)
            this.btnLoad(true);
            var params = { page: this.paginate.next_page }
            if (this.filters.category) {
                params.categories = [this.filters.category];
            }
            this.getProducts(params)
                .finally(() => this.btnLoad(false))
        },

        categoryInFilter(category) {
            return category.id == this.filters.category ? "active-category" : "";
        },

        btnLoad(showLoadign) {
            if (showLoadign) {
                this.btnDisabled = true;
                this.textButton = '<i class="fas fa-spinner fa-spin"></i> Loading...';
            } else {
                this.btnDisabled = false;
                this.textButton = 'Carregar mais produtos'
            }
        }
    },
    mounted() {
        this.getProducts({ page: "" });
        this.getCategories();
    },
    created() {
    },
    watch: {
        company() {
            this.getCart(this.company.uuid);
        }
    },
}
</script>