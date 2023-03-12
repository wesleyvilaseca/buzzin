import axios from "axios";

const actions = {
    getTenant({ commit }, params) {
        commit('SET_PRELOADER', true);
        commit('SET_TEXT_PRELOADER', 'Carregando os produtos...');
        return axios.get('/app/tenant', { params })
            .then(res => { 
                const data = res.data.data;
                const layout = data?.site_data?.layout;

                commit('SET_COMPANY', data);

                if(layout && layout.paleta_cores_site) {
                    commit('SET_PALETA', layout.paleta_cores_site)
                }
             })
            .finally(() => {
                commit('SET_PRELOADER', false)
            });
    },
}

export default actions;