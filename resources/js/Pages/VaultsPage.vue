<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import NavBar from '@/Components/NavBar.vue';
import GoToTopButton from '@/Components/GoToTopButton.vue';
import Footer from '@/Components/Footer.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    myVaults: {
        type: Array,
        required: true,
    },
});

const menuOpen = ref(null);
const toggleMenu = (id) => {
    menuOpen.value = menuOpen.value === id ? null : id;
};

const openVault = (id) => {
    router.get(route('editor'));
};

// Add Vault Modal Logic
const addingVault = ref(false); // Ref to control modal visibility
const formAdd = useForm({
    vault_name: '',
    description: '',
});

const addVault = () => {
    addingVault.value = true; // Open the modal
};

const submitVault = () => {
    formAdd.post(route('vaults.store'), {
        onSuccess: () => {
            addingVault.value = false; // Close the modal
            formAdd.reset(); // Optionally reset the form after successful creation
        },
    });
};

const cancelAdd = () => {
    addingVault.value = false;
    formAdd.reset();
};

// Edit Vault Modal Logic
const editingVault = ref(null);
const formEdit = useForm({
    vault_name: '',
    description: '',
});

const editVault = (vault) => {
    editingVault.value = vault;
    formEdit.vault_name = vault.vault_name;
    formEdit.description = vault.description;
};

const updateVault = () => {
    formEdit.put(route('vaults.update', editingVault.value.vault_id), {
        onSuccess: () => {
            editingVault.value = null; // Close the modal after successful update
            formEdit.reset(); // Optionally reset the form after successful update
        },
    });
};

const cancelEdit = () => {
    editingVault.value = null;
};

// Delete Vault
const deleteVault = (id) => {
    router.delete(route('vaults.destroy', id));
};

const deleteContibutedVault = (id) => {
    //This need to be fixed in the future if we gonna implement contributed vaults.
    //For now just refresh the page to show the proper behaviour.
    router.reload()
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
                <div v-for="vault in myVaults" :key="vault.vault_id"
                    class="bg-white p-4 shadow-md rounded-xl border border-gray-300">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-xl font-bold text-darkest">{{ vault.vault_name }}</h3>
                        <div class="relative">
                            <button @click="toggleMenu(vault.vault_id)" class="text-gray-600 hover:text-gray-900">
                                ⋮ <!-- Vertical Ellipsis ⋮ -->
                            </button>

                            <div v-if="menuOpen === vault.vault_id"
                                class="absolute right-0 mt-2 w-32 bg-white shadow-lg border rounded-lg z-10">
                                <button @click="editVault(vault)"
                                    class="block w-full text-left px-4 py-2 hover:bg-gray-100">Edit</button>
                                <button @click="deleteVault(vault.vault_id)"
                                    class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Delete</button>
                            </div>
                        </div>
                    </div>

                    <p class="text-darkest text-sm">{{ vault.description || "No description available." }}</p>

                    <button @click="openVault(vault.vault_id)"
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
                                ⋮ <!-- Vertical Ellipsis ⋮ -->
                            </button>

                            <div v-if="menuOpen === vault.id"
                                class="absolute right-0 mt-2 w-32 bg-white shadow-lg border rounded-lg z-10">
                                <button @click="deleteContibutedVault(vault.id)"
                                    class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Delete</button>
                            </div>
                        </div>

                    </div>

                    <p class="text-darkest text-sm">{{ vault.description || "No description available." }}</p>

                    <button @click="openVault(vault.id)"
                        class="w-full mt-4 bg-lightest text-darkest py-2 rounded-md hover:brightness-75 transition">
                        Open Vault
                    </button>
                </div>
            </div>
        </section>

        <Footer />

        <!-- Add Vault Modal -->
        <div v-if="addingVault"
            class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-2xl font-bold text-darkest mb-4">Add New Vault</h2>

                <div class="mb-4">
                    <label for="add-vault-name" class="block text-gray-700 text-sm font-bold mb-2">Vault Name:</label>
                    <input type="text" id="add-vault-name" v-model="formAdd.vault_name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    <div v-if="formAdd.errors.vault_name" class="text-red-500 text-xs italic">{{
                        formAdd.errors.vault_name }}</div>
                </div>

                <div class="mb-6">
                    <label for="add-vault-description"
                        class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                    <textarea id="add-vault-description" v-model="formAdd.description" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    <div v-if="formAdd.errors.description" class="text-red-500 text-xs italic">{{
                        formAdd.errors.description }}</div>
                </div>

                <div class="flex justify-end">
                    <button @click="cancelAdd"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition mr-2">Cancel</button>
                    <button @click="submitVault"
                        class="bg-darkest text-white px-4 py-2 rounded-lg hover:brightness-75 transition">Create
                        Vault</button>
                </div>
            </div>
        </div>

        <!-- Edit Vault Modal -->
        <div v-if="editingVault"
            class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-2xl font-bold text-darkest mb-4">Edit Vault</h2>

                <div class="mb-4">
                    <label for="edit-vault-name" class="block text-gray-700 text-sm font-bold mb-2">Vault Name:</label>
                    <input type="text" id="edit-vault-name" v-model="formEdit.vault_name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" />
                    <div v-if="formEdit.errors.vault_name" class="text-red-500 text-xs italic">{{
                        formEdit.errors.vault_name }}</div>
                </div>

                <div class="mb-6">
                    <label for="edit-vault-description"
                        class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                    <textarea id="edit-vault-description" v-model="formEdit.description" rows="3"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                    <div v-if="formEdit.errors.description" class="text-red-500 text-xs italic">{{
                        formEdit.errors.description }}</div>
                </div>

                <div class="flex justify-end">
                    <button @click="cancelEdit"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition mr-2">Cancel</button>
                    <button @click="updateVault"
                        class="bg-darkest text-white px-4 py-2 rounded-lg hover:brightness-75 transition">Update
                        Vault</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
