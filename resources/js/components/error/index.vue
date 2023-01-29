<template>
    <small class="text-red-600">
        {{ message }}
    </small>
</template>

<script>

import { computed } from 'vue';

export default {
    name: "Error",

    props: {
        errors: {
            type: Array,
            required: true,
        },
    },

    setup(props) {
        const message = computed(() => {
            const messages = props.errors;

            const output = [];

            for (const message of messages) {
                output.push(message.$message);
            }

            return output.join(' | ');
        });

        return {
            message,
        };
    },
}
</script>

<style scoped>

</style>
