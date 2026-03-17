<script setup>
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import NavBar from '@/Components/NavBar.vue';
import GoToTopButton from '@/Components/GoToTopButton.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    myVaults: Array,
    contributedVaults: Array,
});

// State for Modals/Menus
const addingVault = ref(false);
const editingVault = ref(false);
const menuOpen = ref(null);
const currentEditId = ref(null);

// Inertia Forms
const formAdd = useForm({
    name: '',
    description: '',
});

const formEdit = useForm({
    name: '',
    description: '',
});

const toggleMenu = (id) => {
    menuOpen.value = menuOpen.value === id ? null : id;
};

// --- CRUD Actions ---

const addVault = () => {
    addingVault.value = true;
};

const cancelAdd = () => {
    addingVault.value = false;
    formAdd.reset();
    formAdd.clearErrors();
};

const submitVault = () => {
    formAdd.post(route('vaults.store'), {
        onSuccess: () => cancelAdd(),
    });
};

const editVault = (vault) => {
    menuOpen.value = null;
    currentEditId.value = vault.id;
    formEdit.name = vault.name;
    formEdit.description = vault.description;
    editingVault.value = true;
};

const cancelEdit = () => {
    editingVault.value = false;
    currentEditId.value = null;
    formEdit.reset();
    formEdit.clearErrors();
};

const updateVault = () => {
    formEdit.patch(route('vaults.update', currentEditId.value), {
        onSuccess: () => cancelEdit(),
    });
};

const deleteVault = (id) => {
    if (confirm('Are you sure you want to delete this vault?')) {
        router.delete(route('vaults.destroy', id));
    }
};

const openVault = (id) => {
    router.get(route('vaults.show', id));
};
</script>
<template>
    <AppLayout>
        <Head title="Vaults" />
        <NavBar />
        <GoToTopButton />

        <!-- MY VAULTS SECTION -->
        <section class="container mx-auto py-12 px-4">
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

            <!-- Vault Cards Grid -->
            <div v-if="myVaults && myVaults.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                <div v-for="vault in myVaults" :key="vault.id"
                    class="bg-white p-4 shadow-md rounded-xl border border-gray-300 flex flex-col h-full">

                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-darkest truncate pr-4">{{ vault.name }}</h3>

                        <!-- Dropdown Menu -->
                        <div class="relative">
                            <button @click="toggleMenu(vault.id)" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                                ⋮
                            </button>

                            <div v-if="menuOpen === vault.id"
                                class="absolute right-0 mt-2 w-32 bg-white shadow-lg border rounded-lg z-10 overflow-hidden">
                                <button @click="editVault(vault)"
                                    class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-100 transition">
                                    Edit
                                </button>
                                <button @click="deleteVault(vault.id)"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 transition">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm flex-grow mb-4 line-clamp-3">
                        {{ vault.description || "No description available." }}
                    </p>

                    <button @click="openVault(vault.id)"
                        class="w-full mt-auto bg-darkest text-white py-2 rounded-md hover:brightness-75 transition">
                        Open Vault
                    </button>
                </div>
            </div>

            <!-- Empty State for My Vaults -->
            <div v-else class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <p class="text-gray-500 mb-4">You don't have any vaults yet.</p>
                <button @click="addVault" class="text-darkest font-semibold hover:underline">
                    Create your first vault
                </button>
            </div>
        </section>

        <!-- CONTRIBUTED VAULTS SECTION -->
        <section class="container mx-auto py-10 px-4 flex-grow">
            <div class="mb-6">
                <h2 class="text-4xl font-semibold text-darkest mb-6">Contributed Vaults</h2>
                <div class="w-full h-px bg-gray-300"></div>
            </div>

            <!-- Vault Cards Grid -->
            <div v-if="contributedVaults && contributedVaults.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                <div v-for="vault in contributedVaults" :key="vault.id"
                    class="bg-white p-4 shadow-md rounded-xl border border-gray-300 flex flex-col h-full">

                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h3 class="text-xl font-bold text-darkest truncate">{{ vault.name }}</h3>
                            <span class="text-xs text-gray-500 border border-gray-200 px-2 py-1 rounded-full mt-1 inline-block">
                                Owner: {{ vault.owner?.name || 'Unknown' }}
                            </span>
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="relative">
                            <button @click="toggleMenu(vault.id)" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                                ⋮
                            </button>

                            <div v-if="menuOpen === vault.id"
                                class="absolute right-0 mt-2 w-32 bg-white shadow-lg border rounded-lg z-10 overflow-hidden">
                                <button @click="leaveVault(vault.id)"
                                    class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 transition">
                                    Leave Vault
                                </button>
                            </div>
                        </div>
                    </div>

                    <p class="text-gray-600 text-sm flex-grow my-4 line-clamp-3">
                        {{ vault.description || "No description available." }}
                    </p>

                    <button @click="openVault(vault.id)"
                        class="w-full mt-auto bg-gray-200 text-darkest py-2 rounded-md hover:bg-gray-300 transition font-medium">
                        Open Vault
                    </button>
                </div>
            </div>

            <!-- Empty State for Contributed Vaults -->
            <div v-else class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <p class="text-gray-500">No one has shared a vault with you yet.</p>
            </div>
        </section>

        <Footer />

        <!-- ADD VAULT MODAL -->
        <div v-if="addingVault"
            class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-2xl font-bold text-darkest mb-4">Add New Vault</h2>

                <form @submit.prevent="submitVault">
                    <div class="mb-4">
                        <label for="add-vault-name" class="block text-gray-700 text-sm font-bold mb-2">Vault Name <span class="text-red-500">*</span></label>
                        <input type="text" id="add-vault-name" v-model="formAdd.name" required
                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-gray-400" />
                        <div v-if="formAdd.errors.name" class="text-red-500 text-xs mt-1">{{ formAdd.errors.name }}</div>
                    </div>

                    <div class="mb-6">
                        <label for="add-vault-description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea id="add-vault-description" v-model="formAdd.description" rows="3"
                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-gray-400"></textarea>
                        <div v-if="formAdd.errors.description" class="text-red-500 text-xs mt-1">{{ formAdd.errors.description }}</div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="cancelAdd" :disabled="formAdd.processing"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                            Cancel
                        </button>
                        <button type="submit" :disabled="formAdd.processing"
                            class="bg-darkest text-white px-4 py-2 rounded-lg hover:brightness-75 transition disabled:opacity-50">
                            Create Vault
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- EDIT VAULT MODAL -->
        <div v-if="editingVault"
            class="fixed top-0 left-0 w-full h-full bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
                <h2 class="text-2xl font-bold text-darkest mb-4">Edit Vault</h2>

                <form @submit.prevent="updateVault">
                    <div class="mb-4">
                        <label for="edit-vault-name" class="block text-gray-700 text-sm font-bold mb-2">Vault Name <span class="text-red-500">*</span></label>
                        <input type="text" id="edit-vault-name" v-model="formEdit.name" required
                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-gray-400" />
                        <div v-if="formEdit.errors.name" class="text-red-500 text-xs mt-1">{{ formEdit.errors.name }}</div>
                    </div>

                    <div class="mb-6">
                        <label for="edit-vault-description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                        <textarea id="edit-vault-description" v-model="formEdit.description" rows="3"
                            class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-gray-400"></textarea>
                        <div v-if="formEdit.errors.description" class="text-red-500 text-xs mt-1">{{ formEdit.errors.description }}</div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="cancelEdit" :disabled="formEdit.processing"
                            class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                            Cancel
                        </button>
                        <button type="submit" :disabled="formEdit.processing"
                            class="bg-darkest text-white px-4 py-2 rounded-lg hover:brightness-75 transition disabled:opacity-50">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
