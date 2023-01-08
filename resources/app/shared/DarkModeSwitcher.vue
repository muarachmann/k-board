<template>
    <div
        id="kanban_theme_toggle"
        v-on:click="toggle"
        class="cursor-pointer flex items-center justify-center rounded-full w-8 h-8 p-1 mx-1">
        <icon :class="getColor" name="light-bulb" class="flex items-center text-gray-700 dark:text-white"/>
    </div>
</template>

<script>

import { mapGetters } from "vuex";

export default {
    name: "DarkModeSwitcher",
    props: {
        color: null,
    },
    computed: {
        ...mapGetters({theme: "getTheme"}),
        getColor() {
            return this.color !== null ? this.color : "text-black";
        },
    },
    mounted() {
        this.toggleThemeBackground(this.$store.getters.getTheme)
    },
    watch: {
        theme(newTheme) {
            this.toggleThemeBackground(newTheme)
        },
    },
    methods: {
        toggle() {
            this.$store.dispatch("toggleTheme");
        },
        toggleThemeBackground(theme) {
            const darkModeButton = document.querySelector("#kanban_theme_toggle");
            theme === "light" ?
                darkModeButton.classList.remove("bg-yellow-600", "bg-opacity-80") :
                darkModeButton.classList.add("bg-yellow-600", "bg-opacity-80")
        }
    },
}
</script>

<style scoped>

</style>
