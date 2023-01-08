<template>
    <nav class="sticky relative w-full h-20 bg-gray-50 dark:bg-gray-800 px-4 border-b dark:border-gray-600 flex flex-row justify-between items-center">
        <router-link :to="{name: 'home'}" class="outline-none focus:outline-none">
            <div class="flex flex-row items-center justify-center p-2 ease-in-out transform cursor-pointer">
                <img alt="Waspito Logo" :src="'/images/logo.png'" class="h-14"/>
                <h2 class="block p-0 mx-2 text-2xl font-bold tracking-normal">
                    <span class="dark:text-white">Kanban Board</span>
                </h2>
            </div>
        </router-link>
        <div class="hidden md:flex">
            <div class="flex items-center">
                <dark-mode-switcher color="text-white" />
                <router-link
                    v-if="$store.getters.authenticated"
                    :to="{name: 'create-board'}"
                    class="mx-2 inline-flex items-center px-3 py-2 border border-transparent bg-pink-500 text-base leading-6 font-medium rounded-md text-white hover:bg-pink-700 focus:outline-none outline-none transition ease-in-out duration-150">
                        <icon name="plus-circle" class="w-5 h-5"/>
                        <span class="mx-1">New Column</span>
                </router-link>
                <button
                    v-if="$store.getters.authenticated"
                    v-on:click="logout"
                    class="mx-2 inline-flex items-center px-3 py-2 border border-transparent bg-gray-500 text-base leading-6 font-medium rounded-md text-white hover:bg-gray-700 focus:outline-none outline-none transition ease-in-out duration-150">
                    <icon name="logout" class="w-5 h-5"/>
                    <span class="mx-1">Logout</span>
                </button>
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
    methods: {
        logout () {
            this.$store.dispatch('logout' )
        }
    }
}
</script>

<style scoped>

</style>
