import axios from "axios";

const actions = {
    getLayout({ commit }) {
        commit('SET_LAYOUT', { color: '#000' })
    },
}

export default actions;