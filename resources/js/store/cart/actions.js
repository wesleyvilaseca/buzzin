import axios from "axios";
import cript from "../../support/cript";
const actions = {
    getCart({ commit }, uuid) {
        const cart = localStorage.getItem(uuid);
        if (cart) {
            commit('SET_CART', JSON.parse(cript.decript(cart)));
            commit('TOTAL_CART')
        }
    },

    setItemInCart({ commit }, params) {
        commit('ADD_PRODUCT_CART', params)
        commit('TOTAL_CART')
    },

    incrementToCart({ commit }, params) {
        commit('INCREMENT_QTY_PROD_CART', params);
        commit('TOTAL_CART')
    },

    decrementToCart({ commit }, params) {
        commit('DECREMENT_QTY_PROD_CART', params);
        commit('TOTAL_CART')
    },

    removeFromCart({ commit }, params) {
        commit('REMOVE_PROD_CART', params);
        commit('TOTAL_CART')
    },

    shippingValue({ commit }, params) {
        return axios.post('/app/delivery-price', params)
            .then((res) => {
                return res;
            })
    }
}

export default actions;