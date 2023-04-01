import cript from "../../support/cript";

export const mutations = {
    SET_PALETA(state, data) {
        state.paleta = data;
        sessionStorage.setItem('paleta', cript.cript(JSON.stringify(state.paleta)));
    },
}

export default mutations;