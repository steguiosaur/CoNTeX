<script setup>
const currentYear = `2024-${new Date().getFullYear()}`;
</script>

<template>
    <footer class="bg-darkest text-center py-6 text-lighter border-t border-gray-300">
        <div class="space-y-2">
            <p>
                Contribute on
                <a href="https://github.com/steguiosaur/contex" target="_blank" class="text-lightest hover:underline font-semibold">
                    GitHub
                </a>
            </p>
            <p>&copy; CoNTeX {{ currentYear }}. All Rights Reserved.</p>
        </div>
    </footer>
</template>
