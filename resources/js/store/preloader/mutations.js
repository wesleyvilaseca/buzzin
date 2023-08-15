export const mutations = {
    SET_PRELOADER(state, status) {
        console.log(status)
        state.preloader = status
        state.textPreloader = 'Carregando...'
    },

    SET_TEXT_PRELOADER(state, text) {
        state.textPreloader = text
    },

    SET_LOADMORE(state, status) {
        state.loadmore = status;
    }
}

export default mutations;