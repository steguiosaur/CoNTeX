<script setup>
import { ref, onMounted, computed } from 'vue';

const text = ref('');
const mode = ref('split'); // 'edit', 'preview', 'split'

onMounted(() => {
    document.documentElement.classList.add("overflow-hidden"); // Disable page scrolling

    // Add scroll event listeners after the component is mounted
    const sourceText = document.getElementById("source-text");
    const mainPreview = document.getElementById("render-text");

    if (sourceText && mainPreview) {
        // Function to synchronize scrolling
        function syncScroll(event) {
            var target = event.target;
            if (target.id === "source-text") {
                mainPreview.scrollTop = target.scrollTop;
            } else {
                sourceText.scrollTop = target.scrollTop;
            }
        }

        // Add scroll event listeners
        sourceText.addEventListener("scroll", syncScroll);
        mainPreview.addEventListener("scroll", syncScroll);
    } else {
        console.error("source-text or render-text element not found!");
    }
});

const isMobile = computed(() => {
    return window.innerWidth < 768; // Adjust breakpoint as needed
});

const currentMode = computed(() => {
    if (isMobile.value) {
        return mode.value === 'split' ? 'edit' : mode.value; // Mobile always starts with edit
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
    <div class="flex flex-col h-screen w-screen">
        <!-- Navbar -->
        <nav class="bg-darkest text-white py-2 shadow-md flex-shrink-0">
            <div class="mx-auto flex items-center justify-between px-4">
                <div class="flex items-center space-x-6">
                    <button @click="toggleMode('edit')" :class="{'font-bold': currentMode === 'edit'}"
                        class="text-white hover:text-lighter">Edit</button>
                    <button @click="toggleMode('preview')" :class="{'font-bold': currentMode === 'preview'}"
                        class="text-white hover:text-lighter">Preview</button>
                    <button @click="toggleMode('split')" :class="{'font-bold': currentMode === 'split'}"
                        class="text-white hover:text-lighter hidden sm:inline-block">Split</button>
                </div>
                <a href="/" class="flex items-center text-3xl font-bold text-lighter">
                    <img id="logo-img" src="/images/ctx-light.png" alt="CoNTeX" class="h-7 w-auto" />
                </a>
            </div>
        </nav>

        <!-- Main editor container (fills remaining space) -->
        <div class="flex-grow flex" :class="{'flex-col': isMobile}">
            <!-- Textarea (Left) -->
            <textarea v-if="showEditor" v-model="text" :class="['font-jetbrains', 'bg-lightest', textareaWidthClass,
                 'h-full', 'p-8', 'border-r', 'border-gray-300', 'resize-none', 'focus:outline-none', 'overflow-auto', 'flex']"
                placeholder="Start typing..." id="source-text"></textarea>

            <!-- Preview (Right) -->
            <pre v-if="showPreview" :class="['font-sans', previewWidthClass, 'bg-lighter', 'overflow-auto', 'm-0', 'pre-style',
                 'flex', 'h-full', 'p-8']" id="render-text"><code>{{ text }}
                </code>
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
