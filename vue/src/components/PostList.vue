<template>
    hffhhfhf
    <div class="flex flex-col py-4 px-6 shadow-md bg-white hover:bg-gray-50 h-[270px]">
        <h4 class="mt-4 text-lg font-bold">{{ post.title }}</h4>
        <div v-html="post.description" class="overflow-hidden flex-1"></div>
    </div>
</template>

<script setup>
const { post } = defineProps({
    post:Object
})
</script>

<style scoped>

</style>
