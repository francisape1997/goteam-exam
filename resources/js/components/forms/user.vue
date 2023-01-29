<template>
    <div>
        <!-- First Name -->
        <div class="rounded-md shadow-sm -space-y-px">
            <div>
                <label for="first-name" class="sr-only">
                    First Name
                </label>
                <input
                    v-model="form.first_name"
                    name="first-name"
                    type="text"
                    required
                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="First Name"
                >
            </div>
            <Error :errors="validation.first_name.$errors"/>
        </div>

        <!-- Last Name -->
        <div class="rounded-md shadow-sm -space-y-px">
            <div>
                <label for="last-name" class="sr-only">
                    Last Name
                </label>
                <input
                    v-model="form.last_name"
                    name="last-name"
                    type="text"
                    required
                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="Last Name"
                >
            </div>
            <Error :errors="validation.last_name.$errors"/>
        </div>

        <!-- Email -->
        <div
            v-if="!fieldsDisabled.includes('email')"
            class="rounded-md shadow-sm -space-y-px"
        >
            <div>
                <label for="email-address" class="sr-only">
                    Email Address
                </label>
                <input
                    v-model="form.email"
                    name="email"
                    type="email"
                    required
                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="Email address"
                >
            </div>
            <Error :errors="validation.email.$errors"/>
        </div>

        <div>
            <!-- Password -->
            <div
                v-if="!fieldsDisabled.includes('password')"
                class="rounded-md shadow-sm -space-y-px"
            >
                <div>
                    <label for="password" class="sr-only">
                        Password
                    </label>
                    <input
                        v-model="form.password"
                        name="password"
                        type="password"
                        required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Password"
                    >
                </div>
                <Error :errors="validation.password.$errors"/>
            </div>

            <!-- Password Confirmation -->
            <div
                v-if="!fieldsDisabled.includes('password')"
                class="rounded-md shadow-sm -space-y-px"
            >
                <div>
                    <label for="password-confirmation" class="sr-only">
                        Password Confirmation
                    </label>
                    <input
                        v-model="form.password_confirmation"
                        name="password-confirmation"
                        type="password"
                        required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Password Confirmation"
                    >
                </div>
                <Error :errors="validation.password_confirmation.$errors"/>
            </div>
        </div>

        <!-- Date of Birth -->
        <div class="rounded-md shadow-sm -space-y-px">
            <div>
                <label for="date-of-birth" class="sr-only">
                    Date of Birth
                </label>
                <input
                    v-model="form.date_of_birth"
                    name="date-of-birth"
                    type="date"
                    required
                    class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                >
            </div>
            <Error :errors="validation.date_of_birth.$errors"/>
        </div>

    </div>
</template>

<script>
// Vue
import { computed } from 'vue';

// Components
import Error from '@/components/error/index.vue';

export default {
    name: 'UserForm',

    components: {
        Error,
    },

    props: {
        validation: {
            type: Object
        },
        modelValue: {
            type: Object,
        },
        fieldsDisabled: {
            type: Array,
            default: [],
        },
    },

    setup(props, { emit }) {

        const form = computed({
            get() {
                return props.modelValue;
            },
            set(value) {
                emit('update:modelValue', value);
            }
        });

        return {
            form,
        }
    },
}
</script>
