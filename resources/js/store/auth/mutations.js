const mutations = {
    SET_ME(state, me) {
        state.me = me

        state.authenticated = true;
    },

    SET_AUTHENTICATED(state, status) {
        state.authenticated = status;
    },

    LOGOUT(state) {
        state.me = {
            name: '',
            email: ''
        }

        state.authenticated = false;

    },

    SET_ADDRESS(state, address) {
        state.address = address;
    },

    SET_ORDERS(state, data) {
        state.orders = data;
    }

};

export default mutations;
