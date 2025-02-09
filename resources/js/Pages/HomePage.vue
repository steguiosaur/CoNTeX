<script setup>
import { ref } from 'vue';
import { Head, router, usePage } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import NavBar from '@/Components/NavBar.vue';
import GoToTopButton from '@/Components/GoToTopButton.vue';
import Footer from '@/Components/Footer.vue';

const user = usePage().props.auth.user;

const goToRegister = () => { router.get(route('register')); };
const goToLogin = () => { router.get(route('login')); };
const goToVault = () => { router.get(route('vaults.index')); };

const smoothScrollToContent = (target) => {
    const targetSection = document.querySelector(target);
    window.scrollTo({
        top: targetSection.offsetTop,
        behavior: 'smooth',
    });
};
</script>

<template>
    <AppLayout>

        <Head title="Home" />

        <NavBar />

        <GoToTopButton />

        <!-- Welcome page or something -->
        <section class="w-full min-h-screen flex flex-col items-center justify-center
        px-14 py-14">
            <div class="w-full max-w-7xl flex flex-wrap items-center justify-center md:justify-between">

                <div class="w-full pr-0 md:pr-10 md:w-1/2 mb-8 md:mb-0 md:text-left mx-auto flex
                justify-center">
                    <div class="">
                        <h1 class="text-5xl font-bold mb-4 text-gray-900">
                            Write Mathematical Expressions with Ease
                        </h1>
                        <p class="text-xl text-darkest mb-6">
                            Collaborate expression-heavy documents without lifting
                            away from the keyboard
                        </p>
                        <div class="flex md:flex-row gap-4">
                            <template v-if="!user">
                                <button @click="goToRegister"
                                    class="bg-darkest text-white px-8 py-3 border-4 border-darkest hover:brightness-50 transition font-bold">
                                    Sign Up
                                </button>
                                <button @click="goToLogin"
                                    class="bg-lightest text-darkest px-10 py-3 border-4 border-darkest hover:brightness-50 transition font-bold">
                                    Login
                                </button>
                            </template>

                            <template v-else>
                                <button @click="goToVault"
                                    class="w-full bg-darkest text-white px-8 py-3 border-4 border-darkest hover:brightness-50 transition font-bold">
                                    Enter Vault
                                </button>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="w-full py-10 md:w-1/2 flex justify-center">
                    <img src="/images/branchnbound.svg" alt="Branch and Bound" class="max-w-md w-full h-auto" />
                </div>
            </div>

            <div class="mt-14 text-center">
                <a href="#read-more-section" @click.prevent="smoothScrollToContent('#read-more-section')" class="text-darkest hover:underline
                text-lg font-bold">
                    Read More
                </a>
            </div>
        </section>

        <!-- Read more text about this application -->
        <section id="read-more-section" class="container mx-auto py-12 px-4">
            <h3 class="text-4xl font-bold mt-10 text-darkest text-center">
                Texts? Diagrams? Equations? We can handle them all!
            </h3>

            <div class="max-w-4xl mx-auto transform transition duration-500 hover:scale-105 my-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <img src="/images/mdumllatex.svg" alt="Markdown UML LaTeX" class="w-64 h-auto" />
                    <div class="flex flex-col items-center md:items-start text-center md:text-left">
                        <h6 class="text-2xl font-bold text-darkest">Edit with Markdown, LaTeX, and UML</h6>
                        <p class="text-darkest">All in one editor for Markdown, LaTeX, and UML</p>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto transform transition duration-500 hover:scale-105 my-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <img src="/images/skip-connection.svg" alt="Skip Connection" class="w-64 h-auto" />
                    <div class="flex flex-col items-center md:items-start text-center md:text-left">
                        <h6 class="text-2xl font-bold text-darkest">Extended LaTeX Compilation</h6>
                        <p class="text-darkest">Nonlimiting towards compileable LaTeX code compared to StackEdit,
                            Obsidian,
                            etc., that are reliant on MathJax</p>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto transform transition duration-500 hover:scale-105 my-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <img src="/images/bayes.svg" alt="Bayesian Model" class="w-64 h-auto" />
                    <div class="flex flex-col items-center md:items-start text-center md:text-left">
                        <h6 class="text-2xl font-bold text-darkest">Live Rendering</h6>
                        <p class="text-darkest">No manual compilation needed, write your stuff and see the changes in
                            real
                            time</p>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto transform transition duration-500 hover:scale-105 my-8">
                <div class="flex flex-col md:flex-row items-center gap-6">
                    <img src="/images/team-icon.svg" alt="Team Collaboration" class="w-64 h-auto" />
                    <div class="flex flex-col items-center md:items-start text-center md:text-left">
                        <h6 class="text-2xl font-bold text-darkest">Collaboration Made Easy</h6>
                        <p class="text-darkest">Collaborate and share progress with teams</p>
                    </div>
                </div>
            </div>
        </section>

        <Footer />
    </AppLayout>
</template>
