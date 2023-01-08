<template>
    <div class="flex flex-col max-w-4xl mx-auto justify-center items-center">
        <form class="w-full flex flex-col items-center" @submit.prevent="login">
            <div class="w-full px-10">
                <h1 v-if="$store.getters.authenticated" class="text-center font-bold text-3xl">
                    Welcome back, <span class="text-pink-500 dark:text-orange-500">{{ $store.getters.user.name }}</span>
                </h1>
                <h1 v-else class="text-center font-bold text-3xl">
                    Welcome to Kanban Board
                </h1>
                <div class="mx-auto mt-4 w-72 border-b-2 border-pink-500"></div>
                <template v-if="$store.getters.authenticated">
                    <div class="w-full px-10">
                        <div class="w-full flex justify-center items-center">
                            <img class="h-full" :src="'/images/board.png'" alt="error"/>
                        </div>
                        <div class="flex flex-col w-full items-center justify-center my-4">
                            <router-link :to="{name: 'board'}" type="submit" class="w-full inline-flex items-center justify-center text-center px-8 py-3 my-2 mr-2 text-base text-white transition duration-500 ease-in-out transform bg-gray-900 border-gray-700 rounded-md focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-pink-700">
                                <icon name="home" class="w-5 h-5 mx-2"/>
                                View Dashboard
                            </router-link>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="w-full grid grid-cols-6 gap-6 mt-10">
                        <div class="col-span-6">
                            <div class="col-12" v-if="Object.keys(errors).length > 0">
                                <div class="bg-red-100 text-red-600 p-4 rounded">
                                    <ul class="mb-0 text-sm">
                                        <li v-for="(value, key) in errors" :key="key">{{ value }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-6">
                            <label for="email" class="block text-lg font-medium mb-2 text-gray-700">
                                <span>Email</span>
                                <span class="required">*required</span>
                            </label>
                            <input
                                id="email"
                                name="email"
                                v-model="form.email"
                                class="py-2.5 px-3 focus:outline-none outline-none block w-full border rounded leading-normal appearance-none placeholder:text-gray-500 placeholder:opacity-100"
                                placeholder="user@test.com"
                                required
                            />
                        </div>
                        <div class="col-span-6">
                            <div class="flex flex-col capitalize">
                                <label for="password" class="block text-lg font-medium mb-2 text-gray-700">
                                    <span>Password</span>
                                    <span class="required">*required</span>
                                </label>
                                <input
                                    id="password"
                                    name="password"
                                    v-model="form.password"
                                    class="py-2.5 px-3 focus:outline-none outline-none block w-full border rounded leading-normal appearance-none placeholder:text-gray-500 placeholder:opacity-100"
                                    type="password"
                                    placeholder="secret"
                                    required
                                />
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col w-full items-center justify-center my-4">
                        <button type="submit" class="w-full inline-flex items-center justify-center text-center px-8 py-3 my-2 mr-2 text-base text-white transition duration-500 ease-in-out transform bg-gray-900 border-gray-700 rounded-md focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-pink-700">
                            Access Board
                            <icon v-if="isLoading" name="circle-loader" class="w-5 h-5 mx-2 animate-spin"/>
                            <icon v-else name="login" class="w-5 h-5 mx-2"/>
                        </button>
                    </div>
                </template>
            </div>

        </form>
    </div>
</template>

<script>

export default {
    name: "Home",
    data() {
        return {
            user: null,
            isLoading: false,
            form: {
                email: 'muarachmann@gmail.com',
                password: 'kanban-test',
            },
            errors: {},
        }
    },
    methods: {
        async login() {
            this.isLoading = true
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/api/login', this.form).then(({ data }) => {
                this.$store.dispatch('login', {
                    'user': data.user,
                    'access_token': data.access_token
                })
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
        },
    }
}
</script>

<style scoped>

</style>
