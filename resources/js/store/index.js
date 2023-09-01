import { createStore } from 'vuex'
import tenant from "./tenant";
import products from "./products";
import categories from "./categories";
import preloader from "./preloader";
import paginate from "./paginate";
import cart from './cart';
import layout from './layout';
import maintence from './maintence';
import auth from './auth';
import ticket from './ticket';

export default createStore({
    modules: {
        tenant,
        products,
        categories,
        preloader,
        paginate,
        cart,
        layout,
        maintence,
        auth,
        ticket
    }
})