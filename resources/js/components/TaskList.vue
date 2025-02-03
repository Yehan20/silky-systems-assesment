<template>
    <div class="w-full p-6">
      <h2 class="text-xl font-bold mb-4">Tasks</h2>
      <ul>
        <li v-for="task in tasks" :key="task.id" style="margin-bottom: 1em;" class="p-4 bg-white shadow rounded mb-3">
          <h3 class="font-semibold">{{ task.title }}</h3>
          <p>{{ task.description }}</p>
          <p>{{ task.due_date }}</p>
          <p>Assinged To : {{task.team.name ?? 'No Team'}}</p>
          <span class="text-sm text-gray-600">Status: {{ task.status }}</span>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import { mapState, mapActions } from 'vuex';
  
  export default {
    computed: {
      // Map tasks from Vuex store
      ...mapState('tasks', ['tasks']),
    },
    mounted() {
      // Fetch tasks when the component is mounted
      this.fetchAllTasks();
    },
    methods: {
      // Map actions from Vuex store
      ...mapActions('tasks', ['fetchAllTasks']),
    },
  };
  </script>
  
  <style scoped>
  h2 {
    color: #333;
  }
  </style>
  