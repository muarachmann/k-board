import axios from "axios";

export default {
    state: {
        kanban_columns: [],
    },
    getters: {
        getKanbanColumns(state) {
            return state.kanban_columns
        }
    },
    mutations: {
         SET_KANBAN_COLUMNS(state, kanban_columns) {
             state.kanban_columns = kanban_columns
        },
    },
    actions: {
         fetchKanbanColumns({ commit }) {
             axios.get('/api/kanban-columns').then(res => {
                 console.log(res.data)
                 commit('SET_KANBAN_COLUMNS', res.data)
             }).catch(error => {
                console.log(error)
            })
        },
    }
}
