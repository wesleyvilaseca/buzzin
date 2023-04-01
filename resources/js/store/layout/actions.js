import axios from "axios";
import cript from "../../support/cript";

const actions = {
    setPaleta({ commit }, params) {
        const paleta = sessionStorage.getItem('paleta');
        if (paleta) {
            commit('SET_PALETA', JSON.parse(cript.decript(paleta)));
        }
    },
}

export default actions;