<template>
    <div>
        <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Go Team
                    </h2>
                </div>
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email-address" class="sr-only">Email address</label>
                        <input
                            v-model="state.email"
                            name="email"
                            type="email"
                            required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Email address"
                        >
                    </div>
                    <small
                        v-for="(error, index) in v$.email.$errors"
                        :key="error"
                        class="text-red-600">
                        {{ error.$message }}
                    </small>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input v-model="state.password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Password">
                    </div>
                    <small
                        v-for="(error, index) in v$.password.$errors"
                        :key="error"
                        class="text-red-600">
                        {{ error.$message }}
                    </small>
                </div>

                <Button
                    :loading="isLoading"
                    :disabled="!isFormValid"
                    @click="signIn"
                >
                    <template v-slot:name>
                        Sign in
                    </template>
                </Button>

            </div>
        </div>

    </div>
</template>

<script>
// Http
import { http } from '@/services/http.js';

// Axios
import axios from 'axios';

// Vue
import { computed, ref, reactive } from 'vue';

// Router
import { useRouter } from 'vue-router';

// Components
import Button from '@/components/button/index.vue';

import { createToaster } from "@meforma/vue-toaster";

import useVuelidate from '@vuelidate/core';
import { required, email, helpers } from '@vuelidate/validators';

export default {
    name: 'Login',

    components: {
        Button,
    },

    setup() {
        const router = useRouter();

        const state = reactive({
            email: null,
            password: null,
        });

        const rules = computed(() => {
            return {
                email: {
                    required: helpers.withMessage('Email is required', required),
                    email: helpers.withMessage('Email is not in a valid format', email),
                },
                password: {
                    required: helpers.withMessage('Password is required', required),
                },
            };
        });

        const v$ = useVuelidate(rules, state);

        const isLoading = ref(false);

        /**
         * Checks if the form is null or empty string
         * returns bool
         */
        const isFormValid = computed(() => {
            const invalidValues = ['', null];

            return !invalidValues.includes(state.email) && !invalidValues.includes(state.password);
        });

        const signIn = async () => {

            const validate = await v$.value.$validate();

            if (validate) {
                setLoading();

                const toaster = createToaster({});

                const response = await http.post('login', state);

                if (response.status === 200) {
                    localStorage.setItem('token', response.data.token);

                    axios.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem('token')}`;

                    router.push({ path: '/pokemons' });
                } else {
                    toaster.show(response.data.message, {
                        position: 'bottom-left',
                        type: 'error',
                    });
                }

                setLoading();
            }
        };

        const setLoading = () => {
            isLoading.value = !isLoading.value;
        };

        return {
            signIn,
            state,
            isFormValid,
            isLoading,
            v$,
        };
    },
}
</script>

<style scoped>

</style>
