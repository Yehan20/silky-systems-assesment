<template>
    <div class="bg-white p-6 rounded-lg w-full">
      <h2 class="text-xl font-bold mb-4">Your Teams</h2>
  
      <div v-if="teams.length">
        <ul class="list-disc pl-4">
          <li v-for="team in teams" :key="team.id" class="mb-2">
            {{ team.name }}
          </li>
        </ul>
      </div>
  
      <p v-else class="text-gray-500">You are not part of any teams.</p>
    </div>
  </template>
  
  <script>
  import { mapActions, mapState } from "vuex";
  
  export default {
    computed: {
      ...mapState("teams", ["teams"]), // Get teams from Vuex
    },
    mounted() {
      this.fetchTeams(); // Fetch teams when component is mounted
    },
    methods: {
      ...mapActions("teams", ["fetchTeams"]),
    },
  };
  </script>
  