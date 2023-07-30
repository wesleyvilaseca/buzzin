import cript from "../../support/cript";
import { hasWhatsappExtension } from "../../support/whatsappExtension"

const mutations = {
    SET_COMPANY(state, company) {
        state.company = company
        sessionStorage.setItem('company', cript.cript(JSON.stringify(state.company)));
    },

    SET_EXTENSIONS(state, extensions) {
        var hasWhatsapp = hasWhatsappExtension(extensions);
        
        if(hasWhatsapp) {
            state.extensions.whatsapp.active = true;
            state.extensions.whatsapp.data = hasWhatsapp;
        }

        state.extensions.data = extensions;

        sessionStorage.setItem('extensions', cript.cript(JSON.stringify(state.extensions)));
    },
}

export default mutations;