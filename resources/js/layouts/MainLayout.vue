<template>
    <TopNav class="mb-5"/>

    <router-view/>
</template>

<script>
import TopNav from '@/components/header/index.vue';
export default {
    name: "MainLayout",
    components: {
        TopNav,
    },
}
</script>
