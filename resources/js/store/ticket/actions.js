import axios from "axios";

const actions = {
    getTicket({ commit }, id) {
        return axios.get(`/api/v1/${id}/ticket`)
            .then(res => {
                commit('SET_TICKET', res.data)
            })
    },

    getTicketSupport({ commit }, id) {
        return axios.get(`/api/v1/${id}/ticket-support`)
            .then(res => {
                commit('SET_TICKET', res.data)
            })
    },

}

export default actions;