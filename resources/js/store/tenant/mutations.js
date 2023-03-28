import cript from "../../support/cript";

const mutations = {
    SET_COMPANY(state, company) {
        state.company = company
        sessionStorage.setItem('company', cript.cript(JSON.stringify(state.company)));
    },
}

export default mutations;