<script setup>
import { ref, onMounted, computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import parseMarkdown from '@/utils/markdownParser';
import { escapeSpecialChars } from '@/utils/markdownParser';

const text = ref('');
const parsedHTMLSections = computed(() => {
    const escapedText = escapeSpecialChars(text.value);
    return parseMarkdown(escapedText);
});
const mode = ref('split');
const isFileTreeOpen = ref(false);

const toggleFileTree = () => {
    isFileTreeOpen.value = !isFileTreeOpen.value;
};

onMounted(() => {
    document.documentElement.classList.add("overflow-hidden");

    const sourceText = document.getElementById("source-text");
    const mainPreview = document.getElementById("render-text");

    if (sourceText && mainPreview) {
        function syncScroll(event) {
            var target = event.target;
            if (target.id === "source-text") {
                mainPreview.scrollTop = target.scrollTop;
            } else {
                sourceText.scrollTop = target.scrollTop;
            }
        }

        sourceText.addEventListener("scroll", syncScroll);
        mainPreview.addEventListener("scroll", syncScroll);
    } else {
        console.error("source-text or render-text element not found!");
    }
});

const isMobile = computed(() => {
    return window.innerWidth < 768;
});

const currentMode = computed(() => {
    if (isMobile.value) {
        return mode.value === 'split' ? 'edit' : mode.value;
    }
    return mode.value;
});

const showEditor = computed(() => {
    return currentMode.value === 'edit' || currentMode.value === 'split';
});

const showPreview = computed(() => {
    return currentMode.value === 'preview' || currentMode.value === 'split';
});

const textareaWidthClass = computed(() => {
    if (currentMode.value === 'edit') return 'w-full';
    return 'w-1/2';
});

const previewWidthClass = computed(() => {
    if (currentMode.value === 'preview') return 'w-full';
    return 'w-1/2';
});

const toggleMode = (newMode) => {
    mode.value = newMode;
};
</script>

<template>
    <div class="flex h-screen w-screen">
        <Head title="Editor" />

        <!-- File Tree (Left Sidebar) -->
        <aside :class="[
            'bg-darkest',
            'border-r',
            'border-gray-700',
            'text-white',
            'flex-shrink-0',
            'overflow-y-auto',
            'z-20',
            // Visibility based on isFileTreeOpen and screen size
            isMobile ? (isFileTreeOpen ? 'fixed inset-y-0 left-0 w-full' : 'hidden') : (isFileTreeOpen ? 'w-64' : 'hidden'),
        ]">
            <!-- Mobile Close Button -->
            <button v-if="isMobile && isFileTreeOpen" @click="toggleFileTree" class="absolute top-2 right-2 p-1 hover:bg-gray-700 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="p-4">
                <h2 class="font-semibold mb-2 text-lighter">Documents</h2>
                <button class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded mb-4 block w-full text-center">
                    Create Document
                </button>
                <ul>
                    <li v-for="file in ['Document 1.md', 'My Notes.txt', 'Project Ideas.md']" :key="file"
                        class="p-2 hover:bg-darker cursor-pointer rounded">
                        {{ file }}
                        <div class="hidden hover:block absolute bg-darkest border border-gray-700 rounded shadow-md p-2 z-30">
                            <button class="block hover:bg-darker px-2 py-1 rounded w-full text-left text-white">Rename</button>
                            <button class="block hover:bg-darker px-2 py-1 rounded w-full text-left text-white">Delete</button>
                        </div>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content Container (Editor and Preview) -->
        <div class="flex-grow flex flex-col h-screen w-full">
            <!-- Navbar -->
            <nav class="bg-darkest text-white py-2 shadow-md flex-shrink-0">
                <div class="mx-auto flex items-center justify-between px-4">
                    <div class="flex items-center space-x-6">
                        <!-- File Tree Toggle Button (Always Visible) -->
                        <button @click="toggleFileTree" class="text-white hover:text-lighter mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                            </svg>
                        </button>
                        <button @click="toggleMode('edit')" :class="{ 'font-bold': currentMode === 'edit' }"
                            class="text-white hover:text-lighter">Edit</button>
                        <button @click="toggleMode('preview')" :class="{ 'font-bold': currentMode === 'preview' }"
                            class="text-white hover:text-lighter">Preview</button>
                        <button @click="toggleMode('split')" :class="{ 'font-bold': currentMode === 'split' }"
                            class="text-white hover:text-lighter hidden sm:inline-block">Split</button>
                    </div>
                    <a href="/" class="flex items-center text-3xl font-bold text-lighter">
                        <img id="logo-img" src="/images/ctx-light.png" alt="CoNTeX" class="h-7 w-auto" />
                    </a>
                </div>
            </nav>

            <!-- Editor and Preview Container (fills remaining space) -->
            <div class="flex-grow flex" :class="{ 'flex-col': isMobile }">
                <!-- Textarea (Left) -->
                <textarea v-if="showEditor" v-model="text"
                    :class="['font-jetbrains', 'bg-lightest', textareaWidthClass,
                        'h-full', 'p-8', 'border-r', 'border-gray-300', 'resize-none', 'focus:outline-none', 'overflow-auto', 'flex']"
                    placeholder="Start typing..." id="source-text"></textarea>

                <!-- Preview (Right) -->
                <pre v-if="showPreview" :class="['font-sans', previewWidthClass, 'bg-lighter', 'pre-style',
                    'flex', 'h-full', 'p-8']" id="render-text">
                    <code class="font-sans"><div v-for="(sectionHTML, index) in parsedHTMLSections" :key="index" class="section-container" v-html="sectionHTML"></div>
                    </code>
                </pre>
            </div>

            <footer class="bg-darkest text-white text-sm py-2 px-4 flex justify-between items-center h-8 textarea-style flex-shrink-0">
                <span>Untitled.md | 123:3</span>
            </footer>
        </div>
    </div>
</template>

<style scoped>
html,
body {
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
    overflow-wrap: break-word;
    word-break: break-word;
}

.section-container {
    margin-bottom: 1em;
}
</style>
