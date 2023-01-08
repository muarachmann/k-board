<template>
    <div
        id="kanban_theme_toggle"
        v-on:click="toggleTheme(theme)"
        :class="theme === 'dark' ? 'bg-yellow-600' : 'bg-gray-100'"
        class="cursor-pointer flex items-center justify-center rounded-full w-8 h-8 p-1 mx-1">
        <icon :class="getColor" name="light-bulb" class="flex items-center text-gray-700 dark:text-white"/>
    </div>
</template>

<script>

export default {
    name: "DarkModeSwitcher",
    props: {
        color: null,
    },
    computed: {
        getColor() {
            return this.color !== null ? this.color : "text-gray-700";
        },
    },
    data() {
        return {
            theme: localStorage.theme ? localStorage.theme : 'light'
        }
    },
    methods: {
        toggleTheme(theme) {
            const darkModeButton = document.querySelector("#kanban_theme_toggle");
            const html = document.querySelector("html");
            switch (theme) {
                case 'light':
                    this.theme = "dark"
                    localStorage.theme = "dark"
                    html.classList.add("dark")
                    break;
                default:
                    this.theme = "light"
                    localStorage.theme = "light"
                    html.classList.remove("dark")
                    break;
            }
        }
    },
}
</script>

<style scoped>

</style>
