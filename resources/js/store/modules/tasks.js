import axios from '../../axios';

export default {
    namespaced: true,
    state: {
        tasks: [],  // List of tasks
        validationErrors: {},  // Store validation errors
    },
    mutations: {
        setTasks(state, tasks) {
            state.tasks = tasks;
        },
        addTask(state, task) {
            state.tasks.push(task);
        },
        updateTask(state, updatedTask) {
            const index = state.tasks.findIndex(task => task.id === updatedTask.id);
            if (index !== -1) {
                state.tasks[index] = updatedTask;
            }
        },
        deleteTask(state, taskId) {
            state.tasks = state.tasks.filter(task => task.id !== taskId);
        },
        setValidationErrors(state, errors) {
            state.validationErrors = errors;  // Store validation errors
        },
        clearValidationErrors(state) {
            state.validationErrors = {};  // Clear errors
        },
    },
    actions: {
        async fetchTasks({ commit }) {
            try {
                const response = await axios.get('/api/tasks');
                commit('setTasks', response.data);
            } catch (error) {
                console.error("Failed to fetch tasks", error);
            }
        },

        async fetchAllTasks({ commit }) {
            try {
                const response = await axios.get('/api/tasks/all');
                commit('setTasks', response.data);
            } catch (error) {
                console.error("Failed to fetch tasks", error);
            }
        },

        async createTask({ commit }, taskData) {
            try {
                const response = await axios.post('/api/tasks', taskData);
                commit('addTask', response.data);  // Add new task to the store
                commit('clearValidationErrors');  // Clear validation errors on successful creation
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const validationErrors = error.response.data.errors;
                    console.error("Failed to create task", validationErrors);
                    commit('setValidationErrors', validationErrors);  // Store validation errors in Vuex
                } else {
                    console.error("Failed to create task", error);
                }
            }
        },
       

          // Update task (status, assigned user)
        async updateTask({ commit }, { taskId, status, userId }) {
           commit("clearValidationErrors"); // Clear old errors
  
        try {
          const response = await axios.put(`/api/tasks/${taskId}`, { status, user_id: userId });
          
          // If status is 200, task updated successfully
          if (response.status === 200) {
            return { success: true, message: "Task updated successfully!" };
          }
  
          return { success: false, message: "Error updating task." };
        } catch (error) {
          if (error.response && error.response.data.errors) {
            commit("setValidationErrors", error.response.data.errors);
          }
          return { success: false, message: "Error updating task." };
        }
        },


          // Fetch users for the task's team
         async fetchUsersForTeam({ commit }, teamId) {
                try {
                const response = await axios.get(`/api/teams/${teamId}/users`);
                commit("setUsersForTeam", response.data);
                } catch (error) {
                console.error("Error fetching users for team:", error);
                }
            },



        async deleteTask({ commit }, taskId) {
            try {
                await axios.delete(`/api/tasks/${taskId}`);
                commit('deleteTask', taskId);  // Remove task from the store
            } catch (error) {
                console.error("Failed to delete task", error);
            }
        },
    },
    getters: {
        getTasks(state) {
            return state.tasks;
        },
        getValidationErrors(state) {
            return state.validationErrors;  // Getter to access validation errors
        },
    },
};
