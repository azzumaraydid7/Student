<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Welcome" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center sm:pt-0 px-2">
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <router-link :to="'/'">Home</router-link>
        </div>

        <div class="w-full mx-auto sm:px-6 lg:px-8 overflow-auto">
            <router-view></router-view>
        </div>
    </div>
</template>
