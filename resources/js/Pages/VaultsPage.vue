<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import NavBar from '@/Components/NavBar.vue';
import GoToTopButton from '@/Components/GoToTopButton.vue';
import Footer from '@/Components/Footer.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const myVaults = ref([
    {
        id: 1, name: 'Personal Notes', description: 'Notes for personal projects',
        owner: 'Steve'
    },
    {
        id: 2, name: 'Work Projects', description: 'Work-related notes', owner:
            'Steve'
    },
]);

const contributedVaults = ref([
    { id: 3, name: 'Team Research', owner: 'Alice' },
    { id: 4, name: 'Shared Ideas', owner: 'Bob' },
]);

const addVault = () => {
    const newVault = {
        id: Date.now(),
        name: 'New Vault',
        description: '',
        owner: 'You',
    };
    myVaults.value.push(newVault);
};

const menuOpen = ref(null);

const toggleMenu = (id) => {
    menuOpen.value = menuOpen.value === id ? null : id;
};

const editVault = (vault) => {
    console.log("Editing vault:", vault);
    // Implement your edit logic here
};

const deleteVault = (id) => {
    myVaults.value = myVaults.value.filter(vault => vault.id !== id);
};

const deleteContibutedVault = (id) => {
    contributedVaults.value = contributedVaults.value.filter(vault => vault.id !== id);
};

const openVault = (id) => {
    router.get(route('editor'));
};
</script>

<template>
    <AppLayout>

        <Head title="Vaults" />

        <NavBar />
        <GoToTopButton />

        <section class="container mx-auto py-12 px-4 ">
            <div class="mb-6">
                <div class="flex justify-between items-center">
                    <h2 class="text-4xl font-semibold text-darkest">My Vaults</h2>
                    <button @click="addVault"
                        class="bg-darkest text-white px-4 py-2 rounded-lg hover:brightness-75 transition">
                        + Add Vault
                    </button>
                </div>
                <div class="w-full h-px bg-gray-300 mt-6"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                <div v-for="vault in myVaults" :key="vault.id"
                    class="bg-white p-4 shadow-md rounded-xl border border-gray-300">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-xl font-bold text-darkest">{{ vault.name }}</h3>
                        <div class="relative">
                            <button @click="toggleMenu(vault.id)" class="text-gray-600 hover:text-gray-900">
                                &#x22EE; <!-- Vertical Ellipsis ⋮ -->
                            </button>

                            <div v-if="menuOpen === vault.id"
                                class="absolute right-0 mt-2 w-32 bg-white shadow-lg border rounded-lg z-10">
                                <button @click="editVault(vault)"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100">Edit</button>
                                <button @click="deleteVault(vault.id)"
                                    class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Delete</button>
                            </div>
                        </div>
                    </div>

                    <p class="text-darkest text-sm">{{ vault.description || "No description available." }}</p>

                    <p class="text-sm text-gray-600 mt-2">Owner: {{ vault.owner }}</p>

                    <button @click="openVault(vault.id)"
                        class="w-full mt-4 bg-darkest text-white py-2 rounded-md hover:brightness-75 transition">
                        Open Vault
                    </button>
                </div>
            </div>
        </section>

        <section class="container mx-auto py-10 px-4 flex-grow">
            <div class="mb-6">
                <h2 class="text-4xl font-semibold text-darkest mb-6">Contributed Vaults</h2>
                <div class="w-full h-px bg-gray-300"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                <div v-for="vault in contributedVaults" :key="vault.id"
                    class="bg-white p-4 shadow-md rounded-xl border border-gray-300">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-xl font-bold text-darkest">{{ vault.name }}</h3>

                        <div class="relative">
                            <button @click="toggleMenu(vault.id)" class="text-gray-600 hover:text-gray-900">
                                &#x22EE; <!-- Vertical Ellipsis ⋮ -->
                            </button>

                            <div v-if="menuOpen === vault.id"
                                class="absolute right-0 mt-2 w-32 bg-white shadow-lg border rounded-lg z-10">
                                <button @click="deleteContibutedVault(vault.id)"
                                    class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Delete</button>
                            </div>
                        </div>

                    </div>

                    <p class="text-darkest text-sm">{{ vault.description || "No description available." }}</p>

                    <p class="text-sm text-gray-600 mt-2">Owner: {{ vault.owner }}</p>

                    <button @click="openVault(vault.id)"
                        class="w-full mt-4 bg-lightest text-darkest py-2 rounded-md hover:brightness-75 transition">
                        Open Vault
                    </button>
                </div>
            </div>
        </section>

        <Footer />
    </AppLayout>
</template>
