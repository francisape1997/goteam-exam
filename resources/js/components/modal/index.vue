<template>
    <div v-show="open">
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 pin overflow-auto">
            <div class="fixed md:relative align-top m-auto justify-center md:rounded w-full h-full flex flex-col content-center items-center">
                <div class="relative bg-white rounded-md py-12 px-12 " :class="[modalSizes[size]]">
                    <!-- Close button -->
                    <div class="absolute top-0 right-0 p-2">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 stroke-rose-500 cursor-pointer"
                            @click="$emit('close')"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="2"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>

                    <div class="mb-3">
                        <slot name="header" />
                    </div>

                    <slot name="body" />

                    <div class="mt-6">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { ref } from 'vue';

export default {
    name: 'Modal',

    emits: ['close'],

    props: {
        size: {
            type: String,
            default: 'md'
        },

        open: {
            type: Boolean,
            default: false,
        },
    },

    setup() {
        const modalSizes = ref({
            "sm": "w-full md:w-1/4",
            "md": "w-full md:w-1/3",
            "lg": "w-full md:w-1/2"
        });

        return {
            modalSizes,
        }
    },
}

</script>

<style scoped>

</style>
