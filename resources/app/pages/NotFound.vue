<template>
    <div class="flex flex-col max-w-2xl mx-auto justify-center items-center">
        <div class="w-full px-10">
            <h1 class="text-center font-bold text-4xl dark:text-pink-500 my-6">Oops page not found!</h1>
            <div class="w-full flex justify-center items-center">
                <img class="h-64" :src="'/images/404.png'" alt="error"/>
            </div>
            <div class="flex flex-col w-full items-center justify-center my-4">
                <router-link to="/" type="submit" class="w-full inline-flex items-center justify-center text-center px-8 py-3 my-2 mr-2 text-base text-white transition duration-500 ease-in-out transform bg-gray-900 border-gray-700 rounded-md focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-pink-700">
                    <icon name="home" class="w-5 h-5 mx-2"/>
                    Back to home
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "NotFound"
}
</script>

<style scoped>

</style>
