import axios from "axios";

const actions = {
    getCategories({ commit }, uuid) {
        commit('SET_TEXT_PRELOADER', 'Carregando as categorias...');

        const params = { uuid };

        return axios.get(`/app/category`, { params })
            .then(res => {
                commit('SET_CATEGORIES_COMPANY', res.data)
            })
    },

}

export default actions;