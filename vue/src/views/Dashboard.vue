<template>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">My Post</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <!-- Replace with your content -->
            <div class="px-4 py-6 sm:px-0">
                <div v-if="posts">
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2">
                        <div v-for="(post, index) in posts" :key="index">
                            <div
                                class="flex flex-col py-4 px-6 shadow-md bg-white hover:bg-gray-50 h-[370px]">
                                <h4 class="mt-4 text-lg font-bold">{{ post.title }}</h4>
                                <div v-html="post.description" class="overflow-hidden flex-1"></div>
                                <div v-html="post.published_at"
                                     class="overflow-hidden flex-1 mt-5"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex justify-center mt-5 mb-5" v-if="links">
                    <nav class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
                         aria-label="Pagination">
                        <a
                            v-for="(link, i) of links"
                            :key="i"
                            :disabled="!link.url"
                            href="#"
                            @click="getForPage($event, link)"
                            aria-current="page"
                            class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                            :class="[
              link.active
                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
              i === 0 ? 'rounded-l-md bg-gray-100 text-gray-700' : '',
              i === links.length - 1 ? 'rounded-r-md' : '',
            ]"
                            v-html="link.label"
                        >
                        </a>
                    </nav>
                </div>
            </div>
            <!-- /End replace -->
        </div>
    </main>
</template>

<script setup>
import store from "../store";
import {computed} from "vue";

store.dispatch("getUserPosts");

const posts = computed(() => store.getters.getAllPosts);
const links = computed(() => store.state.links);


function getForPage(ev, link) {
    ev.preventDefault();

    if (!link.url || link.active) {
        return;
    }

    store.dispatch("getUserPosts", { url: link.url });
}

</script>

<style scoped>

</style>
