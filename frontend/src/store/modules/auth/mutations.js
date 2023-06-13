export default {
    setAuthData(state, payload) {
        state.token = payload;
    },
    logout(state) {
        state.token = ""
    }
}
