<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';
import { Head, router } from '@inertiajs/vue3';

const showButton = ref(false);
const currentYear = `2024-${new Date().getFullYear()}`;

const goToRegister = () => router.get(route('register'));
const goToLogin = () => router.get(route('login'));

const smoothScrollToContent = (target) => {
    const targetSection = document.querySelector(target);
    window.scrollTo({
        top: targetSection.offsetTop,
        behavior: "smooth",
    });
};

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
};
const handleScroll = () => {
    showButton.value = window.scrollY > 20;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    handleScroll();
});

onBeforeUnmount(() => {
    window.removeEventListener("scroll", handleScroll);
});
</script>

<template>
    <Head title="Home" />
    <!-- Navbar -->
    <nav class="bg-darkest text-white py-2 shadow-md">
        <div class="container mx-auto flex items-center justify-between px-4">
            <a href="/" class="flex items-center text-3xl font-bold
                text-lighter">
                <img id="logo-img" src="/images/ctx-light.png" alt="CoNTeX" class="h-7 w-auto mr-2" />
                CoNTeX
            </a>
        </div>
    </nav>

    <!-- Go to top button -->
    <button v-show="showButton" @click="scrollToTop" title="Go to top" class="fixed bottom-5 right-5 z-50 p-3 bg-lightest text-primary
        border-4 font-bold border-darkest text-darkest rounded-full cursor-pointer
        hover:brightness-50">
        ^
    </button>

    <!-- Welcome page or something -->
    <section class="w-full min-h-screen flex flex-col items-center justify-center
        px-14 py-14">
        <div class="w-full max-w-7xl flex flex-wrap items-center justify-center md:justify-between">

            <div class="w-full md:w-1/2 mb-8 md:mb-0 md:text-left mx-auto flex
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
                        <button @click="goToRegister" class="bg-darkest text-white px-8 py-3
                                border-4 border-darkest
                                hover:brightness-50 transition font-bold">
                            Sign Up
                        </button>
                        <button @click="goToLogin" class="bg-lightest text-darkest px-10 py-3
                                border-4 border-darkest
                                hover:brightness-50 transition font-bold">
                            Login
                        </button>
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
                <div>
                    <h6 class="text-2xl font-bold text-darkest">Edit with Markdown, LaTeX, and UML</h6>
                    <p class="text-darkest">All in one editor for Markdown, LaTeX, and UML</p>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto transform transition duration-500 hover:scale-105 my-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <img src="/images/skip-connection.svg" alt="Skip Connection" class="w-64 h-auto" />
                <div>
                    <h6 class="text-2xl font-bold text-darkest">Extended LaTeX Compilation</h6>
                    <p class="text-darkest">Nonlimiting towards compileable LaTeX code compared to StackEdit, Obsidian,
                        etc., that are reliant on MathJax</p>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto transform transition duration-500 hover:scale-105 my-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <img src="/images/bayes.svg" alt="Bayesian Model" class="w-64 h-auto" />
                <div>
                    <h6 class="text-2xl font-bold text-darkest">Live Rendering</h6>
                    <p class="text-darkest">No manual compilation needed, write your stuff and see the changes in real
                        time</p>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto transform transition duration-500 hover:scale-105 my-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <img src="/images/team-icon.svg" alt="Team Collaboration" class="w-64 h-auto" />
                <div>
                    <h6 class="text-2xl font-bold text-darkest">Collaboration Made Easy</h6>
                    <p class="text-darkest">Collaborate and share progress with teams</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer  -->
    <footer class="bg-darkest text-center py-6 text-lighter border-t border-gray-300">
        <div class="space-y-2">
            <p>
                Contribute on
                <a href="https://github.com/steguiosaur/contex" target="_blank"
                    class="text-lightest hover:underline font-semibold">
                    GitHub
                </a>
            </p>
            <p>&copy; CoNTeX {{ currentYear }}. All Rights Reserved.</p>
        </div>
    </footer>
</template>
