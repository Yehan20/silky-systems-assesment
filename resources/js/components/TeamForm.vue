<template>
  <div class="bg-white p-6 rounded-lg w-full">
      <h2 class="text-xl font-bold mb-4">Create a New Team</h2>

      <!-- Success Message -->
      <div v-if="successMessage" style="background-color:rgb(220 252 231);" class="bg-green-100 text-green-700 p-2 rounded mb-4">
          {{ successMessage }}
      </div>

      <!-- Team Creation Form -->
      <form @submit.prevent="submitTeam">
          <div class="mb-4">
              <label class="block text-gray-700">Team Name</label>
              <input v-model="team.name" type="text" class="w-full p-2 border rounded" required>
              <span v-if="validationErrors.name" style="color:red;" class="mt-2 text-red-500">{{ validationErrors.name[0] }}</span>
          </div>

          <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
              Create Team
          </button>
      </form>
  </div>
</template>

<script>
import { mapActions, mapState, mapGetters } from "vuex/dist/vuex.esm-bundler.js";

export default {
  data() {
      return {
          team: {
              name: ""
          },
          successMessage: null,
      };
  },
  computed: {
      ...mapGetters("teams", ["getValidationErrors"]), // Use Vuex getter
      validationErrors() {
          return this.getValidationErrors || {}; // Ensure it's always an object
      }
  },
  methods: {
      ...mapActions("teams", ["createTeam"]),
      async submitTeam() {
         this.successMessage=''

          const success = await this.createTeam(this.team);
          if (success) {
              this.successMessage = "Team created successfully!";
              this.team.name = ""; // Reset form
          }
      }
  }
};
</script>
