import cript from "../../support/cript";

const mutations = {
    SET_COMPANY(state, company) {
        state.company = company
        sessionStorage.setItem('company', cript.cript(JSON.stringify(state.company)));
    },

    SET_EXTENSIONS(state, extensions) {
        state.extensions.data = extensions
        sessionStorage.setItem('extensions', cript.cript(JSON.stringify(state.extensions)));
    },
}

export default mutations;