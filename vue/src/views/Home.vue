<template>
    <div class="min-h-full">
        <Disclosure as="nav" class="bg-gray-800" v-slot="{ open }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <router-link :to="{name: 'Home'}"
                                         :class="[this.$route.name === 'Dashboard' ?
                                   '' :
                                   '',
                                   'px-3 py-2 rounded-md text-sm font-medium']">
                                <h1 class="text-4xl text-white">Square 1</h1>
                            </router-link>
                        </div>

                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4" v-if="token !== null">
                                <router-link :to="{name: 'Dashboard'}"
                                             :class="[this.$route.name === 'Dashboard' ?
                                   '' :
                                   'text-gray-300 hover:bg-gray-700 hover:text-white',
                                   'px-3 py-2 rounded-md text-sm font-medium']">Dashboard
                                </router-link>

                                <router-link :to="{name: 'Add Post'}"
                                             :class="[this.$route.name === 'Add Post' ?
                                   'text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium' :
                                   'text-gray-300 hover:bg-gray-700 hover:text-white',
                                   'px-3 py-2 rounded-md text-sm font-medium']">Add Post
                                </router-link>
                            </div>
                            <div class="ml-10 flex items-baseline space-x-4" v-if="token === null">
                                <router-link :to="{name: 'Login'}"
                                             class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                    Login
                                </router-link>

                                <router-link :to="{name: 'Register'}"
                                             class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                    Register
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6" v-if="token !== null">
                            <!-- Profile dropdown -->
                            <Menu as="div" class="relative ml-3">
                                <div>
                                    <MenuButton
                                        class="flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                        <span class="sr-only">Open user menu</span>
                                        <img class="h-8 w-8 rounded-full" :src="user.imageUrl"
                                             alt=""/>
                                    </MenuButton>
                                </div>
                                <transition enter-active-class="transition ease-out duration-100"
                                            enter-from-class="transform opacity-0 scale-95"
                                            enter-to-class="transform opacity-100 scale-100"
                                            leave-active-class="transition ease-in duration-75"
                                            leave-from-class="transform opacity-100 scale-100"
                                            leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems
                                        class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                        <MenuItem>
                                            <a @click="logout"
                                               :class="['block px-4 py-2 text-sm text-gray-700 cursor-pointer']">
                                                Logout
                                            </a>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </div>
                    </div>
                    <div class="-mr-2 flex md:hidden">
                        <!-- Mobile menu button -->
                        <DisclosureButton
                            class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                            <span class="sr-only">Open main menu</span>
                            <Bars3Icon v-if="!open" class="block h-6 w-6" aria-hidden="true"/>
                            <XMarkIcon v-else class="block h-6 w-6" aria-hidden="true"/>
                        </DisclosureButton>
                    </div>
                </div>
            </div>

            <DisclosurePanel class="md:hidden">
                <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
                    <DisclosureButton v-for="item in navigation" :key="item.name" as="a"
                                      :href="item.href"
                                      :class="[item.current ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'block px-3 py-2 rounded-md text-base font-medium']"
                                      :aria-current="item.current ? 'page' : undefined">{{
                            item.name
                        }}
                    </DisclosureButton>
                </div>
                <div class="border-t border-gray-700 pt-4 pb-3">
                    <div class="flex items-center px-5">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" :src="user.imageUrl" alt=""/>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium leading-none text-white">{{
                                    user.name
                                }}
                            </div>
                            <div class="text-sm font-medium leading-none text-gray-400">
                                {{ user.email }}
                            </div>
                        </div>

                    </div>
                    <div class="mt-3 space-y-1 px-2">
                        <DisclosureButton
                            @click="logout"
                            class="block rounded-md px-3 py-2 text-base font-medium text-gray-400 hover:bg-gray-700 hover:text-white cursor-pointer">
                            Logout
                        </DisclosureButton>
                    </div>
                </div>
            </DisclosurePanel>
        </Disclosure>

        <div v-if="posts">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-2">
                <div v-for="(post, index) in posts" :key="index">
                    <div
                        class="flex flex-col py-4 px-6 shadow-md bg-white hover:bg-gray-50 h-[370px]">
                        <h4 class="mt-4 text-lg font-bold">{{ post.title }}</h4>
                        <div v-html="post.description" class="overflow-hidden flex-1"></div>
                        <div class="overflow-hidden flex-1 mt-2 text-sm">
                            Published At: {{ post.published_at }}
                        </div>
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
</template>

<script setup>
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems
} from '@headlessui/vue'
import {Bars3Icon, XMarkIcon} from '@heroicons/vue/24/outline'
import {useStore} from 'vuex';
import {computed,  onMounted} from "vue";
import {useRouter} from "vue-router";

const store = useStore();
const router = useRouter();

store.dispatch("getPosts");

const user = computed(() => store.state.user.data);
const token = computed(() => store.state.user.token);
const posts = computed(() => store.getters.getAllPosts);
const links = computed(() => store.state.links);

function logout() {
    store.dispatch('logout').then(() => {
        router.push({name: 'Home'});
    });
}

function getForPage(ev, link) {
    ev.preventDefault();
    if (!link.url || link.active) {
        return;
    }
    store.dispatch("getPosts", { url: link.url });
}

const navigation = [
    {name: 'Dashboard', to: "Dashboard"},
]

</script>
