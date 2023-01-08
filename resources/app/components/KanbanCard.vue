<template>
    <div class="relative flex flex-col items-start p-4 mt-3 bg-white rounded-lg cursor-pointer bg-opacity-90 group hover:bg-opacity-100" draggable="true">
        <button class="absolute top-0 right-0 flex items-center justify-center hidden w-5 h-5 mt-3 mr-2 text-gray-500 rounded hover:bg-gray-100 hover:p-1 hover:text-gray-700 group-hover:flex">
            <icon name="move" class="w-5 h-5"/>
        </button>
        <span :class="titleColor" class="flex items-center h-6 px-3 text-xs font-semibold rounded-full">{{ card.title }}</span>
        <h4 class="mt-3 text-sm font-medium">
            {{ card.description }}
        </h4>
    </div>
</template>
<script>
export default {
    name: "KanbanCard",
    props: {
        card: {
            type: Object,
            default: () => ({})
        }
    },
    computed: {
        titleColor() {
            if (this.card.title.length > 1 && this.card.title.length < 10) {
                return 'text-green-500 bg-green-100';
            }
            else if (this.card.title.length > 10 && this.card.title.length < 20) {
                return 'text-blue-500 bg-blue-100';
            } else {
                return 'text-pink-500 bg-pink-100'
            }
        }
    },
};
</script>
