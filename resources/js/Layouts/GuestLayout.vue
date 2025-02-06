<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen flex-col items-center bg-lightest pt-6 sm:justify-center sm:pt-0">
        <div class="m-1">
            <a href="/" class="flex items-center text-5xl font-bold text-darkest">
                <img id="logo-img" src="/images/ctx-dark.png" alt="CoNTeX" class="h-10 w-auto mr-2" /> CoNTeX
            </a>
        </div>

        <div class="mt-6 w-full overflow-hidden px-12 py-14 sm:max-w-md
bg-white p-4 shadow-md rounded-xl border border-gray-300
            ">
            <slot />
        </div>
    </div>
</template>
