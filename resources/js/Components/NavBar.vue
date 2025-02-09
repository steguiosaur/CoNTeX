<script setup>
import { ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

const { user } = usePage().props.auth;
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const logout = () => {
    router.post(route('logout'))
};
</script>

<style scoped>
.truncate {
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
</style>

<template>
    <nav class="bg-darkest text-white py-2 shadow-md">
        <div class="container mx-auto flex items-center justify-between px-4">
            <a href="/" class="flex items-center text-3xl font-bold text-lighter">
                <img id="logo-img" src="/images/ctx-light.png" alt="CoNTeX" class="h-7 w-auto mr-2" />
                CoNTeX
            </a>

            <div class="flex items-center space-x-6">
                <template v-if="user">
                    <div class="relative">
                        <button @click="toggleDropdown"
                            class="flex items-center space-x-2 text-white hover:text-lighter font-bold">
                            <!-- Truncate username to 10 characters -->
                            <span :title="user.name" class="truncate w-24">{{ user.name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div v-if="isDropdownOpen"
                            class="absolute right-0 mt-2 w-40 bg-white text-darkest shadow-lg border rounded-lg z-10">
                            <a href="/profile" class="block px-4 py-2 text-sm hover:bg-gray-100">Profile</a>
                            <a href="/vaults" class="block px-4 py-2 text-sm hover:bg-gray-100">Vaults</a>
                            <button @click="logout"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                        </div>
                    </div>
                </template>


            </div>
        </div>
    </nav>
</template>

