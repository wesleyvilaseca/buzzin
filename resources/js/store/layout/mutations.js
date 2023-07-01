import cript from "../../support/cript";

export const mutations = {
    SET_PALETA(state, data) {
        state.paleta = data;
        localStorage.setItem('paleta', cript.cript(JSON.stringify(state.paleta)));
    },
}

export default mutations;