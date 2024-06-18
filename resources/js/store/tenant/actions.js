import axios from "axios";
import cript from "../../support/cript";

const actions = {
    getTenant({ commit }, params) {
        commit('SET_TEXT_PRELOADER', 'Carregando os produtos...');

        const hasSession = sessionStorage.getItem('company');
        if (hasSession) {
            commit('SET_COMPANY', JSON.parse(cript.decript(hasSession)));
        }   

        return axios.get('/app/tenant', { params })
            .then(res => {
                const data = res.data.data;
                const layout = data?.site_data?.layout;

                commit('SET_COMPANY', data);

                if (layout && layout.paleta_cores_site) {
                    commit('SET_PALETA', layout.paleta_cores_site)
                }
            })
    },

    getSiteExtensions({ commit }, params) {
        const hasSession = sessionStorage.getItem('extensions');
        if (hasSession) {
            const extensions = JSON.parse(cript.decript(hasSession));
            commit('SET_EXTENSIONS', extensions.data);
        }

        return axios.get('/app/site-extensions', { params })
            .then(res => {
                commit('SET_EXTENSIONS', res.data);
            })
    }
}

export default actions;