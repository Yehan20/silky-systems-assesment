import axios from "../../axios";

export default {
  namespaced: true,
  state: {
    teams: [], // List of teams the authenticated user belongs to
    teamUsers: [], // List of users for the selected team
    allUsers: [], // List of all users to add to the team
    validationErrors: {}, // Store validation errors
  },
  mutations: {
    setTeams(state, teams) {
      state.teams = teams;
    },
    setTeamUsers(state, users) {
      state.teamUsers = users;
    },
    setAllUsers(state, users) {
      state.allUsers = users;
    },
    setValidationErrors(state, errors) {
      state.validationErrors = errors;
    },
    clearValidationErrors(state) {
      state.validationErrors = {};
    },
  },
  actions: {
    // Fetch teams the authenticated user belongs to
    async fetchTeams({ commit }) {
      try {
        const response = await axios.get("/api/teams"); // Call API
        commit("setTeams", response.data); // Store teams in Vuex
      } catch (error) {
        console.error("Failed to fetch teams", error);
      }
    },

    async fetchAllTeams({ commit }) {
      try {
        const response = await axios.get("/api/teams/all"); // Call API
        commit("setTeams", response.data); // Store teams in Vuex
      } catch (error) {
        console.error("Failed to fetch teams", error);
      }
    },

    // Fetch users for a selected team
    async fetchTeamUsers({ commit }, teamId) {
      try {
        const response = await axios.get(`/api/teams/${teamId}/users`);
        commit("setTeamUsers", response.data);
      } catch (error) {
        console.error("Failed to fetch users for team", error);
      }
    },

    // Fetch all users (to assign them to a team)
    async fetchAllUsers({ commit }) {
      try {
        const response = await axios.get("/api/teams/users");
        commit("setAllUsers", response.data);
      } catch (error) {
        console.error("Failed to fetch users", error);
      }
    },

    // Add user to the selected team
    async addUserToTeam({ commit, dispatch }, { teamId, userId }) {
      commit("clearValidationErrors"); // Clear old errors
      try {
        const response = await axios.post(`/api/teams/${teamId}/users`, { user_id: userId });

        console.log("User added to team response:", response); // Debugging log

        if (response.status >= 200 && response.status < 300) {
          // Refresh team users list after adding a user
          dispatch("fetchTeamUsers", teamId);
          return { success: true, message: "User added to team successfully!" };
        }

        return { success: false, message: "Unexpected API response." };
      } catch (error) {
        console.error("Error adding user to team:", error.response || error.message); // Debugging log

        if (error.response && error.response.data.errors) {
          commit("setValidationErrors", error.response.data.errors);
          return { success: false, message: "Validation error occurred." };
        }

        return { success: false, message: "An error occurred while adding the user to the team." };
      }
    },

    // **Create a new team**
    async createTeam({ commit, dispatch }, teamData) {
      commit("clearValidationErrors"); // Clear previous validation errors
      try {
        const response = await axios.post("/api/teams", teamData);

        console.log("Create team response:", response); // Debugging log

        if (response.status === 201) {
          dispatch("fetchTeams"); // Refresh the team list
          return true;
        }

        return false;
      } catch (error) {
        console.error("Error creating team:", error.response || error.message); // Debugging log

        if (error.response && error.response.data.errors) {
          commit("setValidationErrors", error.response.data.errors);
        }
        return false;
      }
    },
  },
  getters: {
    getValidationErrors(state) {
      return state.validationErrors;
    },
  },
};
