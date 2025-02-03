<template>
  <div class="bg-white p-6 rounded-lg w-full">
    <h2 class="text-xl font-bold mb-4">Update Task</h2>

    <!-- Task Selection Dropdown -->
    <div class="mb-4">
      <label class="block text-gray-700">Select Task</label>
      <select v-model="selectedTaskId" class="w-full p-2 border rounded" @change="loadTaskDetails">
        <option value="" disabled>Select a Task</option>
        <option v-for="task in tasks" :key="task.id" :value="task.id">
          {{ task.title }}
        </option>
      </select>
    </div>

    <!-- Task Status Input -->
    <div v-if="selectedTaskId" class="mb-4">
      <label class="block text-gray-700">Task Status</label>
      <select v-model="selectedStatus" class="w-full p-2 border rounded">
        <option value="" disabled>Select Status</option>
        <option value="Pending">Pending</option>
        <option value="In Progress">In Progress</option>
        <option value="Completed">Completed</option>
      </select>
    </div>

    <!-- User Selection Input (Based on Task's Team) -->
    <div v-if="selectedTaskId && usersForTeam.length" class="mb-4">
      <label class="block text-gray-700">Assigned User</label>
      <select v-model="selectedUserId" class="w-full p-2 border rounded">
        <option value="" disabled>Select a User</option>
        <option v-for="user in usersForTeam" :key="user.id" :value="user.id">
          {{ user.name }} ({{ user.email }})
        </option>
      </select>
    </div>

    <!-- Update Task Button -->
    <div v-if="selectedTaskId && selectedStatus && selectedUserId" class="mt-4">
      <button @click="handleUpdateTask" class="bg-blue-500 px-4 py-2 rounded hover:bg-blue-600">
        Update Task
      </button>
    </div>

    <!-- Success Message -->
    <div v-if="successMessage" class="mt-4 text-green-500">
      <p>{{ successMessage }}</p>
    </div>

    <!-- Error Message -->
    <div v-if="errorMessage" class="mt-4 text-red-500">
      <p>{{ errorMessage }}</p>
    </div>
  </div>
</template>

<script>
import { mapActions, mapState } from "vuex";

export default {
  data() {
    return {
      selectedTaskId: "", // Selected task ID
      selectedStatus: "", // Selected task status
      selectedUserId: "", // Selected assigned user ID
      successMessage: "", // Success message after task update
      errorMessage: "", // Error message after failed update
    };
  },
  computed: {
    ...mapState("tasks", ["tasks", "usersForTeam"]), // Get tasks and usersForTeam from Vuex store
  },
  mounted() {
    this.fetchAllTasks(); // Fetch all tasks on component mount
  },
  methods: {
    ...mapActions("tasks", ["fetchAllTasks", "fetchTaskDetails", "updateTask"]),
    ...mapActions("teams", ["fetchUsersForTeam"]),

  

    // Load task details based on selected task
    async loadTaskDetails() {
      const selectedTask = this.tasks.find(task => task.id === this.selectedTaskId);
      if (selectedTask) {
        this.selectedStatus = selectedTask.status;
        this.selectedUserId = selectedTask.user_id;

        // Fetch users for the selected task's team
        this.fetchUsersForTeam(selectedTask.team_id);
      }
    },

    // Handle the task update
    async handleUpdateTask() {
      this.successMessage = "";
      this.errorMessage = "";

      if (!this.selectedTaskId || !this.selectedStatus || !this.selectedUserId) {
        this.errorMessage = "Please select all fields to update the task.";
        return;
      }

      const result = await this.updateTask({
        taskId: this.selectedTaskId,
        status: this.selectedStatus,
        userId: this.selectedUserId,
      });

      if (result.success) {
        this.successMessage = result.message;
      } else {
        this.errorMessage = result.message;
      }
    },
  },
};
</script>
y