<template>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">My Post</h1>
        </div>
    </header>
    <main>
        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <!-- Replace with your content -->
            <form class="mt-8 space-y-6" @submit="createPost">
                <div class="px-4 py-6 sm:px-0">
                    <div class="mt-6 flex flex-col">
                        <div class="mb-5 flex flex-col">
                            <label for="">Title</label>
                            <input type="text" required
                                   v-model="post.title"
                                   class="h-10 py-3 px-2 box-border rounded-md hover:border-gray-400 focus:border-gray-400 text-gray-700 block w-full outline-none focus:ring-0 placeholder-gray-400 focus:placeholder-gray-400 font-normal border-gray-300">
                        </div>

                        <div class="mb-5 flex flex-col">
                            <label for="">Description</label>
                            <input type="text" required
                                   v-model="post.description"
                                   class="h-10 py-3 px-2 box-border rounded-md hover:border-gray-400 focus:border-gray-400 text-gray-700 block w-full outline-none focus:ring-0 placeholder-gray-400 focus:placeholder-gray-400 font-normal border-gray-300">
                        </div>

                        <div>
                            <button type="submit"
                                    class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                          <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
                                          aria-hidden="true"/>
                        </span>
                                Post Blog
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- /End replace -->
        </div>
    </main>
</template>

<script setup>
import store from "../store";
import {useRouter} from "vue-router";

const router = useRouter();

const post = {
    title: '',
    description: '',
};

function createPost(ev) {
    ev.preventDefault();

    store.dispatch("createPost", post).then(() => {
        router.push({name: 'Dashboard'})
    }).catch(err => {
        errorMsg.value = err.message;
    });
}

</script>

<style scoped>

</style>
