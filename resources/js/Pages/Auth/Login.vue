<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Login" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>

                <h2 class="text-2xl text-center font-bold text-darkest">Log in to your Account</h2>

                <br>

                <InputLabel for="email" value="Email:" />

                <TextInput id="email" type="email" class="mt-1 p-3 block w-full" v-model="form.email" required autofocus
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password:" />

                <TextInput id="password" type="password" class="mt-1 p-3 block w-full" v-model="form.password" required
                    autocomplete="current-password" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-darker">Remember me</span>
                </label>
            </div>

            <PrimaryButton class="mt-4 w-full mx-auto" :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing">
                Login
            </PrimaryButton>


            <div class="mt-4 flex flex-col items-center space-y-2">
                <Link v-if="canResetPassword" :href="route('password.request')" class="text-sm text-darker underline hover:text-darkest
                    focus:outline-none focus:ring-2 focus:ring-bluish">
                Forgot your password?
                </Link>

                <div>
                    <span class="text-sm text-darker">Don't have an account? </span>
                    <Link :href="route('register')" class="text-darker underline
                        hover:text-darkest focus:outline-none focus:ring-2 focus:ring-bluish
                        text-sm">Sign Up</Link>
                </div>
            </div>
        </form>
    </GuestLayout>
</template>
