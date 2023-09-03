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

    getTicketsByAttendant({ commit }) {
        return axios.get('/api/v1/tickets-by-attendant')
            .then(res => {
                commit('SET_MY_TICKETS', res)
            })
    },

    getTicketsByTenant({ commit }) {
        return axios.get('/api/v1/tickets-by-tenant')
            .then(res => {
                commit('SET_MY_TICKETS', res)
            })
    },

    sendSupportTicketMessage({ commit }, params) {
        return axios.post(`/api/v1/${params.ticket_id}/ticket-support`, params, {})
            .then((res) => {
                commit('SET_NEW_MESSAGE_TICKET', res.data.data)
            })
    },

    sendSupportTenatMessage({ commit }, params) {
        return axios.post(`/api/v1/${params.ticket_id}/ticket`, params, {})
            .then((res) => {
                commit('SET_NEW_MESSAGE_TICKET', res.data.data)
            })
    }

}

export default actions;