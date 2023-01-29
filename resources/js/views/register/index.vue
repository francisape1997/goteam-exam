<template>
    <div>
        <div
            class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8"
        >
            <div class="max-w-md w-full space-y-8">
                <div>
                    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Register Account
                    </h2>
                </div>

                <UserForm
                    v-model="form"
                    :validation="v$"
                />

                <div>
                    <button
                        :disabled="loading"
                        @click="register"
                        :class="{ 'opacity-25 cursor-not-allowed': loading }"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">

                        <!-- Spinner -->
                        <Spinner v-if="loading" />

                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        Register
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

// Vue
import { computed, reactive, ref } from 'vue';

// Vuelidate
import useVuelidate from '@vuelidate/core';
import { required, email, sameAs, helpers } from '@vuelidate/validators';

// Components
import Spinner from '@/components/spinner/index.vue';

// Toaster
import { createToaster } from "@meforma/vue-toaster";

// Router
import { useRouter } from 'vue-router';

// Http
import { http } from '@/services/http.js';

// Helpers
import { setToken } from "@/helpers/index.js";

import UserForm from '@/components/forms/user.vue';

export default {
    name: "Register",

    components: {
        Spinner,
        UserForm,
    },

    setup() {
        const router = useRouter();

        const form = reactive({
            email: null,
            first_name: null,
            last_name: null,
            password: null,
            password_confirmation: null,
            date_of_birth: null,
        });

        const loading = ref(false);

        const rules = computed(() => {
            return {
                email: { required, email },
                first_name: { required },
                last_name: { required },
                password: {
                    required: helpers.withMessage('Password is required', required)
                },
                password_confirmation: {
                    required: helpers.withMessage('Password confirmation is required', required),
                    sameAs: helpers.withMessage('Password confirmation does not match', sameAs(form.password))
                },
                date_of_birth: {
                    required,
                },
            };
        });

        const v$ = useVuelidate(rules, form);

        const setLoading = () => {
            loading.value = !loading.value;
        };

        const register = async () => {
            const validate = await v$.value.$validate();

            setLoading();

            if (validate) {
                const toaster = createToaster({});

                const response = await http.post('register', form);

                if (response.status === 200) {
                    setToken(response.data.token);

                    await router.push('/pokemons');
                } else {
                    toaster.show(response.data.message, {
                        position: 'bottom-left',
                        type: 'error',
                    });
                }
            }

            setLoading();
        };

        return {
            form,
            v$,
            register,
            loading,
        };
    },
}
</script>
