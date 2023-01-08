<template>
    <div class="bg-white dark:bg-gray-700" role="dialog" tabindex="-1">
        <div class="p-8 relative">
            <button class="absolute right-5 top-5" @click="$emit('close')">
                <Icon class="w-6 h-6 text-gray-500" name="close"/>
            </button>
            <div class="w-full overflow-scroll-container">
                <div class="px-4 py-5 sm:px-6">
                    <div class="col-span-6 my-2">
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
                    <form @submit.prevent="addCard(column)">
                        <h3 class="text-xl leading-6 mb-2 font-bold underline text-gray-900 dark:text-white">
                            {{ mode === 'edit' ? 'Update' : 'Add'}} Card
                        </h3>
                        <h3 class="text-xs leading-6 mb-4 font-bold uppercase text-gray-900 dark:text-white">
                            Column: <span class="text-pink-600">{{ column.title }}</span>
                        </h3>
                        <div class="col-span-6 sm:col-span-3 my-2">
                            <input
                                id="title"
                                name="title"
                                v-model="form.title"
                                class="py-2.5 px-3 focus:outline-none outline-none block w-full border rounded leading-normal appearance-none placeholder:text-gray-500 placeholder:opacity-100"
                                placeholder="Maths List"
                                required
                            />
                        </div>
                        <div class="col-span-6 sm:col-span-3 my-2">
                             <textarea
                                 id="email"
                                 name="email"
                                 rows="5"
                                 required
                                 class="py-2.5 px-3 focus:outline-none outline-none block w-full border rounded leading-normal appearance-none placeholder:text-gray-500 placeholder:opacity-100"
                                 v-model="form.description"
                                 placeholder="Solve all maths assignment"
                             ></textarea>
                        </div>
                        <div class="mt-2 py-2 flex justify-end">
                            <button type="submit" class="inline-flex items-center text-center px-8 py-3 my-2 mr-2 text-base text-white transition duration-500 ease-in-out transform bg-gray-900 border-gray-700 rounded-md focus:shadow-outline focus:outline-none focus:ring-2 ring-offset-current ring-offset-2 hover:bg-pink-700">
                                {{ this.mode === 'add' ? 'Add Card' : 'Update Card'}}
                                <icon v-if="isLoading" name="circle-loader" class="w-5 h-5 mx-2 animate-spin"/>
                                <icon v-else name="login" class="w-4 h-4 mx-2"/>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from "axios";

export default {
    name: "AddCardModal",
    props: {
        card: {
            type: Object,
            default: () => ({})
        },
        column: {
            type: Object,
            default: () => ({})
        },
        mode: {
            type: String,
            default: 'add'
        }
    },
    data() {
        return {
            isLoading: false,
            form: {
                id: this.card.id,
                title: this.card.title,
                description: this.card.description,
            },
            errors: {},
            successMessage: null,
        }
    },
    methods: {
        async addCard(column) {
            const self = this
            self.isLoading = true
            await axios.post(`/api/cards/${column.id}/add`, self.form).then(({ data }) => {
                self.updateColumn(column.id, data.card)
                self.isLoading = false
                self.successMessage = data.message
            }).catch(({ response }) => {
                self.isLoading = false
                console.log(response)
                if (response.status === 422) {
                    self.errors = response.data.errors
                } else {
                    self.errors = response.data
                }
            })
        },
        updateColumn(column_id, card) {
            this.$attrs.updateColumn(column_id, card)
        }
    }
}
</script>

<style scoped>

</style>
