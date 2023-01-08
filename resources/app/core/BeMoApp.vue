<template>
    <div class="w-full h-screen bg-gray-50 dark:bg-gray-800">
        <Header/>
        <div class="w-full h-[calc(100%-5rem)] flex overflow-scroll-container text-gray-700 bg-gradient-to-tr from-gray-100 via-pink-200 to-white">
            <router-view> </router-view>
        </div>
    </div>
</template>

<script>
import Header from "../shared/Header.vue";

export default {
    name: "BeMoApp",
    components: {
        Header
    },
    beforeMount() {
        const html = document.querySelector("html");
        switch (localStorage.theme) {
            case 'light':
                localStorage.theme = "light"
                html.classList.remove("dark")
                break;
            default:
                localStorage.theme = "dark"
                html.classList.add("dark")
                break;
        }
    },
    watch: {
        theme(newTheme) {
            let htmlElement = document.documentElement
            newTheme === "light" ?
                htmlElement.classList.remove("dark") :
                htmlElement.classList.add("dark")
        },
    },
}
</script>

<style scoped>

</style>
