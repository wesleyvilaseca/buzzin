import axios from "axios";

const actions = {
    getProducts({ commit }, params) {
        commit('SET_PRELOADER', true);
        commit('SET_TEXT_PRELOADER', 'Carregando os produtos...');
        return axios.get('/app/products', { params })
            .then(res => { 
                commit('SET_PRODUCTS_COMPANY', res.data)
             })
            .finally(() => commit('SET_PRELOADER', false));
    },
}

export default actions;