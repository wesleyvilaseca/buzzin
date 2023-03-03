import { createStore } from 'vuex'
import tenant from "./tenant";
import products from "./products";
import categories from "./categories";
import preloader from "./preloader";

export default createStore({
    modules: {
        tenant,
        products,
        categories,
        preloader
    }
})