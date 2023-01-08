<template>
    <nav class="sticky relative w-full h-20 bg-gray-50 dark:bg-gray-800 px-4 border-b dark:border-gray-600 flex flex-row justify-between items-center">
        <router-link :to="{name: 'home'}" class="outline-none focus:outline-none">
            <div class="flex flex-row items-center justify-center p-2 ease-in-out transform cursor-pointer">
                <img alt="Waspito Logo" :src="'/images/logo.png'" class="h-14"/>
                <h2 class="block p-0 mx-2 text-xs md:text-2xl font-bold tracking-normal">
                    <span class="dark:text-white">Kanban Board</span>
                </h2>
            </div>
        </router-link>
        <div class="flex">
            <div class="flex items-center">
                <dark-mode-switcher/>
                <router-link
                    v-if="$store.getters.authenticated"
                    :to="{name: 'create-board'}"
                    class="mx-2 inline-flex items-center px-3 py-2 border border-transparent bg-pink-500 text-base leading-6 font-medium rounded-md text-white hover:bg-pink-700 focus:outline-none outline-none transition ease-in-out duration-150">
                        <icon name="plus-circle" class="w-5 h-5"/>
                        <span class="mx-1">Column</span>
                </router-link>
                <button
                    v-if="$store.getters.authenticated"
                    v-on:click="logout"
                    class="hidden mx-2 md:inline-flex items-center px-3 py-2 border border-transparent bg-gray-500 text-base leading-6 font-medium rounded-md text-white hover:bg-gray-700 focus:outline-none outline-none transition ease-in-out duration-150">
                    <icon name="logout" class="w-5 h-5"/>
                    <span class="mx-1 hidden md:flex">Logout</span>
                </button>
                <div
                    v-if="$store.getters.authenticated"
                    class="relative md:hidden">
                    <button @click="isOpen = ! isOpen"
                            class="relative inline-flex items-center block h-8 w-8 overflow-hidden focus:outline-none">
                        <icon name="menu" class="h-6 w-6 text-gray-700 dark:text-white"/>
                    </button>
                    <div v-show="isOpen" @click="isOpen = false" class="fixed inset-0 h-full w-full z-9999 bg-black/20"></div>
                    <div v-show="isOpen"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md overflow-hidden shadow-xl z-9999">
                        <router-link :to="{name: 'board'}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-theme-5 hover:text-white">Dashboard</router-link>
                        <router-link :to="{name: 'board-create'}"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-theme-5 hover:text-white">Add Column</router-link>
                        <a @click.prevent="logout" :href="'#'"
                           class="block px-4 py-2 text-sm text-gray-700 hover:bg-theme-5 hover:text-white">
                            Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
<script>

import DarkModeSwitcher from "./DarkModeSwitcher";

export default {
    name: "Header",
    components: {
        DarkModeSwitcher,
    },
    data() {
      return {
          isOpen: false
      }
    },
    methods: {
        logout () {
            this.$store.dispatch('logout' )
        }
    }
}
</script>

<style scoped>

</style>
