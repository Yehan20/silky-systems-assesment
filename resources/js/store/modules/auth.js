import axios from '../../axios';

export default {
    namespaced: true,
    state: {
        user: null,  // Stores authenticated user data
        isAuthenticated: false,  // Authentication status
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
            state.isAuthenticated = true;
        },
        logout(state) {
            state.user = null;
            state.isAuthenticated = false;
        },
    },
    actions: {
        async fetchUser({ commit }) {
            try {
                const response = await axios.get('/api/user');  // Laravel Breeze endpoint to fetch authenticated user
                commit('setUser', response.data);
            } catch (error) {
                console.error("User fetch failed", error);
            }
        },
        async logout({ commit }) {
            try {
                await axios.post('/logout');  // This triggers Laravel's logout via the web route
                commit('logout');
            } catch (error) {
                console.error("Logout failed", error);
            }
        },
    },
    getters: {
        isAuthenticated(state) {
            return state.isAuthenticated;
        },
        getUser(state) {
            return state.user;
        },
    },
};
