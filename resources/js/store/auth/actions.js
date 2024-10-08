import axios from "axios";

const TOKEN_NAME = 'buzzin';

const actions = {
    register({ commit }, params) {
        return axios.post('/app/register', params)
    },

    updateAccount({ dispatch }, params) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;
        return axios.post('/app/auth/account-update', params, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                dispatch('getMe');
            })
    },


    updatePassword({ dispatch, commit }, params) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;

        return axios.post('/app/auth/account-password', params, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                dispatch('getMe');
            })
    },

    login({ commit }, params) {
        return axios.post('/app/login', params)
            .then((res) => {
                const token = res.data.token;
                return new Promise((resolve, reject) => {
                    setTimeout(() => {
                        localStorage.setItem(TOKEN_NAME, token);
                        resolve();
                    }, 0);
                });
            })
    },

    recover({ commit }, params) {
        return axios.post('/app/recover', params);
    },

    resetPassword({ commit }, params) {
        return axios.post('/app/password/reset', params);
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
            .catch(errors => {
                localStorage.removeItem(TOKEN_NAME);
                commit('LOGOUT');
                console.log(errors);
            })
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

    saveNewAddress({ dispatch, commit }, params) {
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

    removeAddress({ dispatch, commit }, params) {
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

        const endpoint = `${process.env.MIX_APP_URL}/api/auth/v1/my-orders`

        return axios.get(endpoint, {
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