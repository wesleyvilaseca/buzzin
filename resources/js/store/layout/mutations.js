export const mutations = {
    SET_PALETA(state, data) {
        state.paleta = data;
        localStorage.setItem('paleta', JSON.stringify(state.paleta));
    },
}

export default mutations;