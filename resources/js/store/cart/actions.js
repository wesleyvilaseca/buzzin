import axios from "axios";
import cript from "../../support/cript";
const TOKEN_NAME = 'buzzin';
const actions = {
    getCart({ commit }, uuid) {
        const cart = sessionStorage.getItem(uuid);
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
                commit('SET_SHIPPING_METHODS', res.data);
            })
    },

    getCepViaCep({ commit }, cep) {
        return axios.get(`https://viacep.com.br/ws/${cep}/json/`);
    },

    sendCheckout({ commit }, params) {
        const token = localStorage.getItem(TOKEN_NAME);

        commit('SET_TEXT_PRELOADER', 'Finalizando pedido...');

        const query_params = new URLSearchParams({
            token_company: params.tenant_uuid,
          }).toString();

        const endpoint = `${process.env.MIX_APP_URL}/api/auth/v1/orders?${query_params}`
        return axios.post(endpoint, params, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .finally(() => {
                commit('SET_TEXT_PRELOADER', 'Carregando...');
            })
    },

    getPaymentMethods({ commit }, params) {
        return axios.post('/app/payment-methods', params)
            .then((res) => {
                commit("SET_PAYMENT_METHODS", res.data);
            })
    }
}

export default actions;