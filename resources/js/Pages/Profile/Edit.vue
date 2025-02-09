<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import NavBar from '@/Components/NavBar.vue';
import Footer from '@/Components/Footer.vue';
import { Head } from '@inertiajs/vue3';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>

    <AppLayout>
        <NavBar />

        <Head title="Profile" />

        <!-- Profile Header -->

        <section class="container mx-auto py-12 px-4 ">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <h2 class="text-4xl font-semibold leading-tight text-gray-800">Profile</h2>
                <div class="w-full h-px bg-gray-300 mt-6"></div>

                <!-- Update Profile Information Form -->
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status"
                        class="max-w-xl" />
                </div>

                <!-- Update Password Form -->
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <!-- Delete User Form -->
                <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </section>

        <Footer />
    </AppLayout>
</template>
