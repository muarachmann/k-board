<template>
    <div class="w-full flex flex-wrap capitalize text-sm">
        <div class="inline-flex" v-for="(pageRoute, index) in pageRoutes" :key="index">
            <div class="rounded font-bold cursor-pointer px-2 py-1 bg-gray-400 dark:bg-gray-100 bg-opacity-30 hover:bg-gray-700 hover:dark:bg-gray-700 hover:text-white">
                <router-link :to="{name: pageRoute.link}">
                    {{ pageRoute.title }}
                </router-link>
            </div>
            <span class="inline-flex justify-center items-center text-gray-600 dark:text-white font-bold mx-2">/</span>
        </div>
        <template v-if="activeLink != null" class="mx-2">
            <div class="rounded px-2 py-1 bg-pink-100 text-pink-800">
                <span class="text-theme-1 font-semibold">
                    {{ activeLink }}
                </span>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        name: "Breadcrumb",
        props: {
            pageRoutes: {
                type: Array,
                required: false
            },
            activeLink: {
                type: String,
                required: true
            }
        },
    }
</script>

<style scoped>

</style>
