import axios from "axios";

const actions = {
    getProducts({ commit }, params) {
        const { page } = params;
        if (page == "") {
            commit('SET_PRELOADER', true);
            commit('SET_TEXT_PRELOADER', 'Carregando os produtos...');
        }

        commit('SET_LOADMORE', true);

        return axios.get('/app/products', { params })
            .then(res => {
                commit('SET_PAGINATE', res.data.meta);
                const { current_page, last_page } = res.data.meta;

                if (current_page === 1) {
                    commit('SET_PRODUCTS_COMPANY', res.data)
                }

                if (current_page > 1) {
                    commit('SET_PRODUCTS_COMPANY_INCREMENT', res.data);
                }

                if (current_page === last_page) {
                    commit('SET_LOADMORE', false);
                }
            })
            .finally(() => commit('SET_PRELOADER', false));
    },
}

export default actions;