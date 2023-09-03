const mutations = {
    SET_TICKET(state, ticket) {
        state.ticket = ticket;
    },

    SET_MY_TICKETS(state, tickets) {
        state.my_tickets = tickets;
    },

    SET_NEW_MESSAGE_TICKET(state, message) {
        var messages = state.ticket;
        messages.data.push(message);
        state.ticket = messages;
    }
}

export default mutations;