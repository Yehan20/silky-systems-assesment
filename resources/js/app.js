import { createApp } from 'vue/dist/vue.esm-bundler.js';
import TaskList from './components/TaskList.vue';
import TaskForm from './components/TaskForm.vue';
import TeamForm from './components/TeamForm.vue';
import ManageTeamUsers from "./components/ManageTeamUsers.vue";
import UsersTeams from './components/UsersTeams.vue';
import UpdateTask from './components/UpdateTask.vue';

import store from './store'; 



const app = createApp({});

app.use(store);

app.component('task-form', TaskForm);
app.component('team-form', TeamForm);
app.component('task-list', TaskList);
app.component("manage-team-users", ManageTeamUsers);
app.component("update-tasks", UpdateTask);
app.component("users-teams",UsersTeams);

app.mount('#app');
