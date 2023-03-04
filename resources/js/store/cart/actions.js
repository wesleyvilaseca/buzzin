const actions = {
    getCart({ commit }, uuid) {
        const cart = localStorage.getItem(uuid);
        if(cart){
            commit('SET_CART', JSON.parse(cart))
        }
    },

    setItemInCart({ commit }, params) {
        commit('ADD_PRODUCT_CART', params)
    },

    incrementToCart({ commit }, params) {
        commit('INCREMENT_QTY_PROD_CART', params);
    },

    removeItemFromCart({ commit }, param) {

    }
}

export default actions;