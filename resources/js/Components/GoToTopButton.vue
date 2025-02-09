<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue';

const showButton = ref(false);

const handleScroll = () => {
    showButton.value = window.scrollY > 20;
};

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth',
    });
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    handleScroll();
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<template>
    <button v-show="showButton" @click="scrollToTop" title="Go to top"
        class="fixed bottom-5 right-5 z-50 p-3 bg-lightest text-primary border-4 font-bold border-darkest text-darkest rounded-full cursor-pointer hover:brightness-50">
        ^
    </button>
</template>
