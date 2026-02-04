<script setup lang="ts">
defineProps<{
    response: string;
}>();
</script>

<template>
    <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
        <div class="mb-4">
            <div class="text-sm font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">Response</div>
        </div>
        <div class="prose prose-gray dark:prose-invert max-w-none rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900" v-html="response"></div>
    </div>
</template>
