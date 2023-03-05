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
        // const googleKey = 'AIzaSyDsoCVJSwyz4lKG4E5A-_X4tZzxKxdDDOY';
        // const apiURL = `https://maps.googleapis.com/maps/api/geocode/json?address=${cep}&key=${googleKey}`;

        return {
            price: 10,
            shipping: false,
            free: false
        };

        return axios.get(apiURL)
            .then((res) => {
                console.log(res)
            })
            .catch((error) => {
                console.log(error)
            })
    }
}

export default actions;