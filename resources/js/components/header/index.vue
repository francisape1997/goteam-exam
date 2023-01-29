<template>
    <Popover class="relative bg-white">
        <div class="w-full mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
                <div class="flex justify-start lg:w-0 lg:flex-1">
                    <a @click="router.push('/pokemons')" class="cursor-pointer">
                        <span class="sr-only">GoTeam</span>
                        <img class="h-8 w-auto sm:h-10" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="" />
                        Pokemons
                    </a>
                </div>

                <div
                    v-if="authenticationRequired"
                    @click="router.push('/users')"
                    class="cursor-pointer whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                >
                    Other Users
                </div>

                <div v-if="authenticationRequired" class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
                    <div class="relative">
                        <button
                            @click="dropDownOpen = !dropDownOpen"
                            :disabled="isLoading"
                            :class="{ 'opacity-25 cursor-not-allowed': isLoading }"
                            class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                        >
                            <Spinner v-if="isLoading" />
                            Profile
                        </button>
                        <div
                            v-if="dropDownOpen"
                            class="absolute right-0 w-48 py-2 mt-1 bg-white rounded-md shadow-lg"
                        >
                            <!-- 1 -->
                            <a
                                @click="signOut()"
                                class="cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-indigo-50"
                                :class="{ 'opacity-25 cursor-not-allowed': isLoading }"
                            >
                                Logout
                            </a>
                            <!-- 2 -->
                            <a
                                @click="router.push('/profile')"
                                class="cursor-pointer block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-indigo-50"
                            >
                                My Profile
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    v-else-if="route.meta.page === 'login'"
                    class="hidden md:flex items-center justify-end md:flex-1 lg:w-0"
                >
                    <button
                        @click="router.push('/register')"
                        class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                    >
                        Register
                    </button>
                </div>

                <div
                    v-else-if="route.meta.page === 'register'"
                    class="hidden md:flex items-center justify-end md:flex-1 lg:w-0"
                >
                    <button
                        @click="router.push('/login')"
                        class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700"
                    >
                        Back
                    </button>
                </div>
            </div>
        </div>
    </Popover>
</template>

<script>

// Http
import { http } from '../../services/http.js';

// Vue
import { ref, computed } from 'vue';

// Router
import { useRouter, useRoute } from 'vue-router';

// Components
import Spinner from '../../components/spinner/index.vue';
import { Popover, PopoverButton, PopoverGroup, PopoverPanel } from '@headlessui/vue';
import {
    MenuIcon,
    XIcon,
} from '@heroicons/vue/outline';

import { authRequired } from "@/helpers/index.js";

export default {
    name: 'TopNav',

    components: {
        Popover,
        PopoverButton,
        PopoverGroup,
        PopoverPanel,
        MenuIcon,
        XIcon,
        Spinner,
    },

    setup() {
        const router = useRouter();

        const route = useRoute();

        const isLoading = ref(false);

        const dropDownOpen = ref(false);

        const setLoading = () => {
            isLoading.value = !isLoading.value;
        };

        const authenticationRequired = computed(() => {
            return authRequired(route.meta.page);
        });

        const signOut = async () => {

            setLoading();

            const response = await http.post('logout');

            if (response.status === 204) {
                localStorage.removeItem('token');

                await router.push('/login');
            }

            setLoading();
        };

        return {
            signOut,
            isLoading,
            authenticationRequired,
            route,
            router,
            dropDownOpen,
        };
    },
}
</script>
