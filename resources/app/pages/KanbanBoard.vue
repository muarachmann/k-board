<template>
    <div class="relative flex flex-col w-screen h-full overflow-auto">
        <div class="px-10 mt-6">
            <h1 class="text-2xl font-bold">Dashboard</h1>
        </div>
        <template v-if="isLoading">
            <div class="flex flex-col items-center justify-center h-screen">
                <icon name="circle-loader" class="w-10 h-10 m-2 text-pink-600 animate-spin"/>
                <p class="text-lg text-gray-700 text-center">
                    Loading your kanban board... <span class="text-pink-500">Please be patient</span>
                </p>
            </div>
        </template>
        <template v-else>
            <div v-if="!kanban_columns.length" class="flex flex-col items-center justify-center h-screen">
                <p class="text-lg text-gray-700 my-4 text-center">
                    Oops your board seems to be empty!<br/>
                    Click on the button below to start creating a new <span class="text-pink-600 font-bold">Column</span>
                </p>
                <router-link
                    v-if="$store.getters.authenticated"
                    :to="{name: 'create-board'}"
                    class="mx-2 inline-flex items-center px-3 py-2 border border-transparent bg-pink-500 text-base leading-6 font-medium rounded-md text-white hover:bg-pink-700 focus:outline-none outline-none transition ease-in-out duration-150">
                    <icon name="plus-circle" class="w-5 h-5"/>
                    <span class="mx-1">New Column</span>
                </router-link>
            </div>
            <div v-else class="flex flex-grow px-10 mt-4 space-x-6 overflow-auto overflow-scroll-container">
                <div v-for="column in kanban_columns" class="flex flex-col flex-shrink-0 w-72">
                    <div class="flex items-center flex-shrink-0 h-10 px-2">
                        <span class="flex items-center h-6 px-3 text-sm font-bold text-white bg-gray-700 rounded">{{ column.title }}</span>
                        <button class="flex items-center justify-center w-6 h-6 ml-auto text-red-700 rounded hover:bg-red-500 hover:text-red-100">
                            <icon name="trash" class="w-5 h-5"/>
                        </button>
                    </div>
                    <div class="flex flex-col pb-2 overflow-auto overflow-scroll-container">
                        <draggable :list="column.cards" :animation="200" ghost-class="ghost-card" group="tasks">
                            <kanban-card
                                v-for="(card) in column.cards"
                                :key="card.id"
                                :card="card"
                                @click.native="showAddCard(column, card)"
                                class="mt-3 cursor-move"
                            ></kanban-card>
                        </draggable>
                        <button
                            @click="showAddCard(column)"
                            class="inline-flex my-4 py-2 px-4 items-center justify-center border border-dashed border-gray-600 text-gray-700">
                            <span>Add Card</span>
                            <icon name="plus-circle" class="h-4 w-4 mx-1"/>
                        </button>
                    </div>
                </div>
                <div class="flex-shrink-0 w-6"></div>
            </div>
        </template>
        <button @click="download" class="absolute bottom-5 right-5 flex items-center justify-center bg-pink-500 py-3 px-6 text-white rounded-full hover:bg-pink-700">
            Export Board
            <icon v-if="isDownloading" name="circle-loader" class="w-5 h-5 mx-2 animate-spin"/>
            <icon v-else name="download" class="w-5 h-5 mx-2"/>
        </button>
    </div>
</template>

<script>
import axios from "axios";

import draggable from "vuedraggable";
import AddCardModal from "../shared/AddCardModal";

export default {
    name: "KanbanBoard",
    data() {
        return {
            isLoading: false,
            isDownloading: false,
            errorMessage: false,
            kanban_columns: [],
            errors: {},
        }
    },
    components: {
        draggable,
        AddCardModal,
    },
    mounted() {
        this.fetchKanbanColumns();
    },
    methods: {
        fetchKanbanColumns() {
            this.isLoading = true
            axios.get('/api/kanban-columns').then(res => {
                this.kanban_columns = res.data
            }).catch(error => {
                this.isLoading = false
                this.errorMessage = "Error fetching kanban board"
                console.log(error)
            }).finally(() => {
                this.isLoading = false
            });
        },
        showAddCard(column, card) {
            this.$modal.show(
                AddCardModal,
                {
                    card: card,
                    mode: card ? 'edit' : 'add',
                    column: column,
                    updateColumn: this.updateColumn,
                },
                {
                    width: 450,
                    height: 'auto',
                    draggable: true,
                    clickToClose: false
                }
            )
        },
        updateColumn(column_id, card) {
            let index = this.kanban_columns.findIndex(col => col.id === column_id);
            console.log(index)
            if (index > -1) {
                console.log(card)
                console.log(card.id)
                let cardIndex = this.kanban_columns[index].cards.findIndex(c => c.id === card.id);
                if (cardIndex > -1) {
                    this.kanban_columns[index].cards[cardIndex - 1] = card;
                } else {
                    this.kanban_columns[index].cards.push(card);
                }
            }
        },
        download() {
            this.isDownloading = true
            axios({
                url: '/api/kanban-board/db/export',
                method: 'GET',
                responseType: 'blob',
            }).then((res) => {
                let file = window.URL.createObjectURL(new Blob([res.data]));
                let docUrl = document.createElement('x');
                docUrl.href = file;
                docUrl.setAttribute('download', 'kanban_board.sql');
                document.body.appendChild(docUrl);
                docUrl.click();
                this.isDownloading = false
            }).catch(({ response }) => {
                this.isDownloading = false
                console.log(response)
                alert('error exporting kanban board')
            }).finally(() => {
                this.isDownloading = false
            });
        }
    }
}
</script>

<style scoped>

</style>
