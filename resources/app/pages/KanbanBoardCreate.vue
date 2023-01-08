<template>
    <div class="p-5 my-5">
        <Breadcrumb :page-routes="pagesRoutes" :active-link="activeLink"/>
        <form @submit.prevent="submit" class="m-5 p-5 shadow dark:bg-gray-900 rounded">
            <h1 class="text-xl font-semibold my-2 dark:text-white">Add Kanban Column</h1>
            <p class="dark:text-white">Create kanban columns and organize your work</p>
            <div class="w-full max-w-md grid grid-cols-6 gap-2 mt-10">
                <div class="col-span-6">
                    <div class="col-12" v-if="Object.keys(errors).length > 0">
                        <div class="bg-red-100 text-red-600 p-4 rounded">
                            <ul class="mb-0 text-sm">
                                <li v-for="(value, key) in errors" :key="key">{{ value }}</li>
                            </ul>
                        </div>
                    </div>
                    <div v-if="successMessage" class="bg-green-100 text-green-600 p-4 rounded">
                        <p class="mb-0 text-sm">{{ successMessage }}</p>
                    </div>
                </div>
                <div class="col-span-6">
                    <label for="email" class="block text-lg font-medium mb-2 text-gray-700 dark:text-white">
                        <span>Title</span>
                        <span class="required">*required</span>
                    </label>
                    <input
                        id="email"
                        name="email"
                        v-model="form.title"
                        class="py-2.5 px-3 focus:outline-none outline-none block w-full border rounded dark:bg-gray-800 dark:text-white leading-normal appearance-none placeholder:text-gray-500 placeholder:opacity-100"
                        placeholder="Column 1'"
                        required
                    />
                </div>
            </div>
            <div class="flex flex-col w-full items-center justify-center my-4">
                <button type="submit" class="w-full inline-flex items-center justify-center text-center px-8 py-3 my-2 mr-2 text-base text-white transition duration-500 ease-in-out transform bg-gray-900 border-gray-700 rounded-md focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-pink-700">
                    Add Column
                    <icon v-if="isLoading" :class="isLoading ? 'animate-spin' : ''" name="circle-loader" class="w-5 h-5 mx-2"/>
                    <icon v-else name="plus-circle" class="w-5 h-5 mx-2"/>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "KanbanBoard",
    data() {
        return {
            errors: {},
            pagesRoutes: [
                {
                    title : 'Dashboard',
                    link : 'board'
                },
            ],
            activeLink: 'Create Column',
            isLoading: false,
            successMessage: null,
            form: {
                title: null
            }
        }
    },
    methods: {
       async submit() {
            this.isLoading = true
            await axios.post('/api/kanban-columns', this.form).then(({ data }) => {
                this.isLoading = false
                this.successMessage = data.message
            }).catch(({ response }) => {
                this.isLoading = false
                if (response.status === 422) {
                    this.errors = response.data.errors
                } else {
                    this.errors = response.data
                }
            }).finally(() => {
                this.isLoading = false
            })
        }
    }
}
</script>

<style scoped>

</style>
