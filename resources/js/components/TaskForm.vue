<template>
  <div class="bg-white p-6 rounded-lg w-full">
    <h2 class="text-xl font-bold mb-4">Create Task</h2>

    <form @submit.prevent="submitTask">
      <!-- Select Team -->
      <div class="mb-4">
        <label class="block text-gray-700">Team</label>
        <select v-model="task.team_id" class="w-full p-2 border rounded" @change="fetchUsers">
          <option value="" disabled>Select a Team</option>
          <option v-for="team in teams" :key="team.id" :value="team.id">
            {{ team.name }}
          </option>
        </select>
        <span v-if="validationErrors.team_id" class="text-red-500">{{ validationErrors.team_id[0] }}</span>
      </div>

      <!-- Task Title -->
      <div class="mb-4">
        <label class="block text-gray-700">Title</label>
        <input v-model="task.title" type="text" class="w-full p-2 border rounded" />
        <span v-if="validationErrors.title" class="text-red-500">{{ validationErrors.title[0] }}</span>
      </div>

      <!-- Task Description -->
      <div class="mb-4">
        <label class="block text-gray-700">Description</label>
        <textarea v-model="task.description" class="w-full p-2 border rounded"></textarea>
        <span v-if="validationErrors.description" class="text-red-500">{{ validationErrors.description[0] }}</span>
      </div>

      <!-- Task Status -->
      <div class="mb-4">
        <label class="block text-gray-700">Status</label>
        <select v-model="task.status" class="w-full p-2 border rounded">
          <option value="pending">Pending</option>
          <option value="in-progress">In Progress</option>
          <option value="completed">Completed</option>
        </select>
        <span v-if="validationErrors.status" class="text-red-500">{{ validationErrors.status[0] }}</span>
      </div>

      <!-- Task Assignment -->
      <div class="mb-4">
        <label class="block text-gray-700">Assign To</label>
        <select v-model="task.assigned_to" class="w-full p-2 border rounded" :disabled="!task.team_id">
          <option value="" disabled>Select a User</option>
          <option v-for="user in users" :key="user.id" :value="user.id">
            {{ user.name }}
          </option>
        </select>
        <span v-if="validationErrors.assigned_to" class="text-red-500">{{ validationErrors.assigned_to[0] }}</span>
      </div>

      <!-- Task Due Date -->
      <div class="mb-4">
        <label class="block text-gray-700">Due Date</label>
        <input v-model="task.due_date" type="date" class="w-full p-2 border rounded" />
        <span v-if="validationErrors.due_date" class="text-red-500">{{ validationErrors.due_date[0] }}</span>
      </div>
  
      <div class="mb-4">
        <button type="submit" class="bg-green-500 px-4 py-2 rounded hover:bg-blue-600">
          Create Task
        </button>
      </div>

    </form>
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex/dist/vuex.esm-bundler.js";

export default {
  data() {
    return {
      task: {
        title: "",
        description: "",
        status: "pending",
        assigned_to: "",
        due_date: "",
        team_id: "",
      },
      users: [], // Will be updated when a team is selected
    };
  },
  computed: {
    ...mapState("teams", ["teams"]), // Get teams from Vuex
    validationErrors() {
      return this.$store.getters["tasks/getValidationErrors"]; // Get validation errors from Vuex
    },
  },
  mounted() {
    this.fetchAllTeams(); // Load teams on component mount
  },
  methods: {
    ...mapActions("teams", ["fetchAllTeams"]), // Fetch teams from Vuex
    ...mapActions("tasks", ["createTask"]), // Create task via Vuex

    // Fetch users when a team is selected
    async fetchUsers() {
      if (!this.task.team_id) {
        this.users = [];
        return;
      }
      try {
        // Dispatch the action to get users in the selected team
        await this.$store.dispatch("teams/fetchTeamUsers", this.task.team_id);
      } catch (error) {
        console.error("Error fetching users:", error);
      }
    },

    async submitTask() {
      await this.createTask(this.task);

      // Reset form if no validation errors
      if (!this.$store.state.tasks.validationErrors) {
        this.task = {
          title: "",
          description: "",
          status: "pending",
          assigned_to: "",
          due_date: "",
          team_id: "",
        };
        this.users = [];
      }
    },
  },
};
</script>
