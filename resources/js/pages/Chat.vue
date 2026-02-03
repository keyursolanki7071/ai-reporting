<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ChatHeader from '../components/Chat/ChatHeader.vue';
import ChatResponse from '../components/Chat/ChatResponse.vue';
import ChatEmptyState from '../components/Chat/ChatEmptyState.vue';
import ChatInput from '../components/Chat/ChatInput.vue';
import { route } from 'ziggy-js';

defineProps<{
    response?: string;
}>();
</script>

<template>
    <Head title="AI Reporting Chat" />

    <div class="flex min-h-screen flex-col bg-gray-50 text-gray-900 dark:bg-zinc-900 dark:text-gray-100">
        <ChatHeader />

        <main class="flex-1 overflow-y-auto p-6">
            <div class="mx-auto max-w-3xl space-y-8">
                <!-- Response Area -->
                <ChatResponse v-if="response" :response="response" />
                 
                <!-- Empty State -->
                <ChatEmptyState v-else />
            </div>
        </main>

        <ChatInput :submit-url="route('chat.store')" />
    </div>
</template>
