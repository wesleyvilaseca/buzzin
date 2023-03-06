import axios from "axios";

const actions = {
    getCart({ commit }, uuid) {
        const cart = localStorage.getItem(uuid);
        if (cart) {
            commit('SET_CART', JSON.parse(cart));
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

    shippingValue({ commit }, cep) {
        axios.get('/app/delivery-price/' + cep)
            .then((res) => {
                console.log(res)
            })

        return {
            price: 10,
            shipping: false,
            free: false
        };
    }
}

export default actions;