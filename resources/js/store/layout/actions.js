import axios from "axios";

const actions = {
    setPaleta({ commit }, params) {
        const paleta = localStorage.getItem('paleta');
        if (paleta) {
            commit('SET_PALETA', JSON.parse(paleta));
        }
    },
}

export default actions;