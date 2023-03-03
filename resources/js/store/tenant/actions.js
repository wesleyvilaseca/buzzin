import axios from "axios";

const actions = {
    getTenant({ commit }, params) {
        commit('SET_PRELOADER', true);
        commit('SET_TEXT_PRELOADER', 'Carregando os produtos...');
        return axios.get('/app/tenant', { params })
            .then(res => { 
                commit('SET_COMPANY', res.data.data)
             })
            .finally(() => commit('SET_PRELOADER', false));
    },
}

export default actions;