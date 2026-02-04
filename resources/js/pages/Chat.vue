<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import ChatResponse from '../components/Chat/ChatResponse.vue';
import ChatEmptyState from '../components/Chat/ChatEmptyState.vue';
import ChatInput from '../components/Chat/ChatInput.vue';
import AppLayout from '../components/AppLayout.vue';
import { route } from 'ziggy-js';

defineProps<{
    response?: string;
    configs?: Array<{ id: number; host: string; database: string }>;
    selected_config_id?: number | null;
}>();
</script>

<template>
    <AppLayout>
        <Head title="AI Reporting Chat" />

        <div class="flex flex-col h-[calc(100vh-theme(spacing.20))]">
            <main class="flex-1 overflow-y-auto pb-6">
                <div class="mx-auto max-w-4xl space-y-8">
                    <!-- Response Area -->
                    <ChatResponse v-if="response" :response="response" />
                     
                    <!-- Empty State -->
                    <ChatEmptyState v-else />
                </div>
            </main>

            <div class="mx-auto w-full max-w-4xl">
                <ChatInput
                    :submit-url="route('chat.store')"
                    :configs="configs"
                    :initial-config-id="selected_config_id"
                />
            </div>
        </div>
    </AppLayout>
</template>
