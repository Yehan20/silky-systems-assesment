import { createStore } from 'vuex/dist/vuex.esm-bundler.js';
import auth from './modules/auth';
import tasks from './modules/tasks';
import teams from './modules/teams';

export default createStore({
    modules: {
        auth,
        tasks,
        teams,
    },
});
