import axios from "axios";

const TOKEN_NAME = 'buzzin';

const actions = {
    register({ commit }, params) {
        commit('SET_PRELOADER', true);

        return axios.post('/app/register', params)
        .finally(() => commit('SET_PRELOADER', false));
    },

    updateAccount({ dispatch }, params) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;

        commit('SET_PRELOADER', true);

        return axios.post('/app/auth/account-update', params, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                dispatch('getMe');
            })
            .finally(() => commit('SET_PRELOADER', false));
    },


    updatePassword({ dispatch, commit }, params) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;

        commit('SET_PRELOADER', true);

        return axios.post('/app/auth/account-password', params, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                dispatch('getMe');
            })
            .finally(() => commit('SET_PRELOADER', false));
    },

    login({ commit }, params) {
        commit('SET_PRELOADER', true);

        return axios.post('/app/login', params)
            .then((res) => {
                const token = res.data.token;
                localStorage.setItem(TOKEN_NAME, token);
            })
            .finally(() => commit('SET_PRELOADER', false));
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

        commit('SET_PRELOADER', true);
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
            .finally(() => commit('SET_PRELOADER', false));
    },

    logout({ commit }) {
        const token = localStorage.getItem(TOKEN_NAME);

        if (!token) return;

        commit('SET_PRELOADER', true);
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
            .finally(() => commit('SET_PRELOADER', false));

    },

    getClientAddress({ commit }) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;

        commit('SET_PRELOADER', true);
        return axios.get('/app/auth/address', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                commit('SET_ADDRESS', res.data);
            })
            .finally(() => commit('SET_PRELOADER', false));
    },

    saveNewAddress({ dispatch, commit }, params) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;

        commit('SET_PRELOADER', true);

        if (!params.id) {

            return axios.post('/app/auth/newaddress', params, {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
                .then((res) => {
                    dispatch('getClientAddress');
                })
                .finally(() => commit('SET_PRELOADER', false));
        }

        return axios.put(`/app/auth/${params.id}/address`, params, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                dispatch('getClientAddress');
            })
            .finally(() => commit('SET_PRELOADER', false));
    },

    removeAddress({ dispatch, commit }, params) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;

        commit('SET_PRELOADER', true);

        return axios.delete(`/app/auth/${params.id}/address`, {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        })
            .then((res) => {
                dispatch('getClientAddress');
            })
            .finally(() => commit('SET_PRELOADER', false));
    },

    getOrders({ commit }, params) {
        const token = localStorage.getItem(TOKEN_NAME);
        if (!token) return;

        commit('SET_PRELOADER', true);

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
            .finally(() => commit('SET_PRELOADER', false));
    }
}

export default actions;