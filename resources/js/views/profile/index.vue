<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                        Update Account
                </h2>
            </div>

            <UserForm
                v-model="form"
                :validation="v$"
                :fieldsDisabled="['email', 'password']"
            />

            <div>
                <button
                    :disabled="loading"
                    @click="update"
                    :class="{ 'opacity-25 cursor-not-allowed': loading }"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">

                    <!-- Spinner -->
                    <Spinner v-if="loading" />

                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    Update
                </button>
            </div>

        </div>
    </div>
</template>

<script>

// Vue
import { computed, ref } from 'vue';

// Vuelidate
import useVuelidate from '@vuelidate/core';
import { required } from '@vuelidate/validators';

// Router
import { useRouter } from 'vue-router';

// Components
import UserForm from '@/components/forms/user.vue';
import Spinner from '@/components/spinner/index.vue';

// Http
import { http } from '@/services/http.js';

// Toaster
import { createToaster } from "@meforma/vue-toaster";

export default {

    components: {
        UserForm,
        Spinner,
    },

    setup() {
        const router = useRouter();

        const form = ref({
            first_name: null,
            last_name: null,
            date_of_birth: null,
        });

        const loading = ref(false);

        const rules = computed(() => {
            return {
                first_name: { required },
                last_name: { required },
                date_of_birth: {
                    required,
                },
            };
        });

        const v$ = useVuelidate(rules, form);

        const setLoading = () => {
            loading.value = !loading.value;
        };

        const update = async () => {
            setLoading();

            const response = await http.put('user/update-profile', form.value);

            const toaster = createToaster();
            
            if (response.status === 200) {
                toaster.show('Update profile successful', {
                    position: 'bottom-left',
                    type: 'success',
                });

                await router.push('/pokemons');
            } else {
                toaster.show('Oops. Something went wrong', {
                    position: 'bottom-left',
                    type: 'error',
                });
            }

            setLoading();
        };

        const fetchAuthUser = async () => {
            const response = await http.get('user');

            if (response.status === 200) {
                const data = response.data;

                form.value.first_name = data.first_name;
                form.value.last_name = data.last_name;
                form.value.date_of_birth = data.date_of_birth;
            }
        };

        fetchAuthUser();

        return {
            v$,
            loading,
            form,
            update,
        };
    },
};
</script>
