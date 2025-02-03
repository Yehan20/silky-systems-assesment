<template>
  <div class="bg-white p-6 rounded-lg w-full">
    <h2 class="text-xl font-bold mb-4">Manage Team Users</h2>

    <!-- Team Selection Dropdown -->
    <div class="mb-4">
      <label class="block text-gray-700">Select a Team</label>
      <select v-model="selectedTeamId" class="w-full p-2 border rounded">
        <option value="" disabled>Select a Team</option>
        <option v-for="team in teams" :key="team.id" :value="team.id">
          {{ team.name }}
        </option>
      </select>
      <p v-if="validationErrors.team_id" class="text-red-500 text-sm mt-1">
        {{ validationErrors.team_id[0] }}
      </p>
    </div>

    <!-- User Selection Dropdown -->
    <div v-if="selectedTeamId" class="mb-4">
      <label class="block text-gray-700">Select a User</label>
      <select v-model="selectedUserId" class="w-full p-2 border rounded">
        <option value="" disabled>Select a User</option>
        <option v-for="user in allUsers" :key="user.id" :value="user.id">
          {{ user.name }} ({{ user.email }})
        </option>
      </select>
      <p v-if="validationErrors.user_id" class="text-red-500 text-sm mt-1">
        {{ validationErrors.user_id[0] }}
      </p>
    </div>

    <!-- Add User to Team Button -->
    <div v-if="selectedTeamId && selectedUserId" class="mt-4">
      <button @click="handleAddUserToTeam" class="bg-green-500 px-4 py-2 rounded hover:bg-green-600">
        Add User to Team
      </button>
    </div>

    <!-- Success Message (Only Shows if No Error) -->
    <div v-if="successMessage && !serverError" class="mt-4 text-green-500">
      <p>{{ successMessage }}</p>
    </div>

    <!-- Display Validation Errors -->
    <div v-if="serverError" class="mt-4 text-red-500">
      <p>{{ serverError }}</p>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
  data() {
    return {
      selectedTeamId: "", // Selected team ID
      selectedUserId: "", // Selected user ID
      serverError: "", // General server error message
      successMessage: "", // Success message after user is added
    };
  },
  computed: {
    ...mapState("teams", ["teams", "allUsers", "validationErrors"]), // Get teams & users from Vuex
  },
  mounted() {
    this.fetchAllTeams();
    this.fetchAllUsers(); // Fetch all users on component mount
  },
  methods: {
    ...mapActions("teams", ["fetchAllTeams", "fetchAllUsers", "addUserToTeam"]),

    async handleAddUserToTeam() {
      this.serverError = ""; // Clear previous errors
      this.successMessage = ""; // Clear any existing success message

      if (!this.selectedTeamId || !this.selectedUserId) {
        this.serverError = "Please select a team and a user.";
        return;
      }

      // Call the Vuex action and handle the result
      const result = await this.addUserToTeam({
        teamId: this.selectedTeamId,
        userId: this.selectedUserId,
      });

      if (result.success) {
        // Success case
        this.successMessage = "User added"
        this.selectedUserId = ""; // Clear selection
      } else {
        // Error case
        this.serverError = result.message;
        this.successMessage = ""; // Clear success message if error occurs
      }
    },
  },
};
</script>
