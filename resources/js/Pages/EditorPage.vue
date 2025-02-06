<script setup>
import { ref, onMounted } from 'vue';

const text = ref('');

onMounted(() => {
    document.documentElement.classList.add("overflow-hidden"); // Disable page scrolling
});
</script>

<template>
    <div class="flex flex-col h-screen w-screen">
        <!-- Navbar -->
        <nav class="bg-darkest text-white py-2 shadow-md flex-shrink-0">
            <div class="mx-auto flex items-center justify-between px-4">
                <div class="flex items-center space-x-6"></div>
                <a href="/" class="flex items-center text-3xl font-bold text-lighter">
                    <img id="logo-img" src="/images/ctx-light.png" alt="CoNTeX" class="h-7 w-auto" />
                </a>
            </div>
        </nav>

        <!-- Main editor container (fills remaining space) -->
        <div class="flex-grow flex">
            <!-- Textarea (Left) -->
            <textarea v-model="text" class="font-jetbrains bg-lightest w-1/2 h-full p-8 border-r border-gray-300
                resize-none focus:outline-none overflow-auto flex" placeholder="Start typing..."></textarea>

            <!-- Preview (Right) -->
            <pre class="font-sans w-1/2 h-full p-8 bg-lighter overflow-auto m-0 pre-style
                flex"><code>{{ text }}</code>
            </pre>
        </div>

        <footer class="bg-darkest text-white text-sm py-2 px-4 flex
            justify-between items-center h-8 textarea-style flex-shrink-0">
            <span>Current File: Untitled.md</span>
            <span>Lines: 0 | Words: 0 | Row: 0, Col: 0</span>
        </footer>
    </div>
</template>

<style scoped>
html, body {
    margin: 0;
    padding: 0;
    overflow: hidden;
    height: 100%;
    width: 100%;
}

.textarea-style {
    overflow-x: hidden;
    word-wrap: break-word;
    max-height: calc(100vh - 88px);
}

.pre-style {
    overflow-x: hidden;
    word-wrap: break-word;
    white-space: pre-wrap;
    max-height: calc(100vh - 76px);
    overflow-wrap: break-word; /* Redundant, but good to have */
    word-break: break-word;    /* Force breaking even mid-word */
}
</style>
