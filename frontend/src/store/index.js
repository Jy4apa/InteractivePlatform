import { createStore } from "vuex";
import auth from "./modules/auth";
import cabinet from "./modules/cabinet";

// * modules
export default createStore({
    modules: {
        auth,
        cabinet
    }
})
