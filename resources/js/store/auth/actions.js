import axios from "axios";

const TOKEN_NAME = 'buzzin';

const actions = {
    register({ commit }, params) {
        return axios.post('/app/register', params);
    },

    login({ commit }, params) {
        return axios.post('/app/login', params)
            .then((res) => {
                const token = res.data.token;
                localStorage.setItem(TOKEN_NAME, token);
            })
    },

    getMe({ commit }) {
        const token = localStorage.getItem(TOKEN_NAME);

        if (!token) return;

        return axios.get('/app/auth/me', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                commit('SET_ME', res.data.data)
            })
            .catch(erros => {
                localStorage.removeItem(TOKEN_NAME);
                alert('operação não authorizada 1');
            });
    },

    logout({ commit }) {
        const token = localStorage.getItem(TOKEN_NAME);

        if (!token) return;

        return axios.post('/app/auth/logout', {}, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                localStorage.removeItem(TOKEN_NAME);
                commit('LOGOUT');
                this.$router.push({ name: 'home' });

            })
            .catch(error => {
                console.log(error);
            })
    },

    getClientAddress({ commit }) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;
        return axios.get('/app/auth/address', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                commit('SET_ADDRESS', res.data);
            })
    },

    saveNewAddress({ dispatch }, params) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;

        if (!params.id) {
            return axios.post('/app/auth/newaddress', params, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
                .then((res) => {
                    dispatch('getClientAddress');
                })
        }

        return axios.put(`/app/auth/${params.id}/address`, params, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                dispatch('getClientAddress');
            })
    },

    removeAddress({ dispatch }, params) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;

        return axios.delete(`/app/auth/${params.id}/address`, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                dispatch('getClientAddress');
            })
    },

    getOrders({ commit }, params) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;

        return axios.get('/app/auth/my-orders', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                const { data } = res;
                commit('SET_ORDERS', data);
            })
    }
}

export default actions;