<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const props = defineProps<{
    submitUrl: string;
    configs?: Array<{ id: number; host: string; database: string }>;
    initialConfigId?: number | null;
}>();

const form = useForm({
    message: '',
    config_id: props.initialConfigId || '',
});

// Watch for prop changes to update form if needed (e.g. on page reload with state)
watch(() => props.initialConfigId, (newVal) => {
    if (newVal) {
        form.config_id = newVal;
    }
});

const loading = ref(false);

const submit = () => {
    if (!form.config_id) {
        alert('Please select a database to query.');
        return;
    }
    if (!form.message) return;
    
    loading.value = true;
    form.post(props.submitUrl, {
        onSuccess: () => {
            form.reset('message');
        },
        onFinish: () => {
            loading.value = false;
        },
        preserveUrl: true,
        preserveState: true, // Keep the selected config_id
    });
};
</script>

<template>
    <div class="fixed bottom-0 left-0 lg:left-72 right-0 bg-gradient-to-t from-white via-white to-transparent pb-6 pt-10 px-4 dark:from-zinc-950 dark:via-zinc-950">
        <div class="mx-auto max-w-3xl">
            <form @submit.prevent="submit" class="relative flex items-center gap-2 rounded-2xl bg-white p-2 shadow-xl shadow-gray-200/50 ring-1 ring-gray-200 transition-all focus-within:ring-2 focus-within:ring-indigo-500/20 dark:bg-zinc-900 dark:shadow-zinc-950/50 dark:ring-zinc-800">
                
                <!-- Database Selector -->
                <div v-if="configs && configs.length > 0" class="relative shrink-0">
                    <div class="group relative flex items-center justify-center rounded-xl bg-gray-50 px-3 py-2 transition-colors hover:bg-gray-100 dark:bg-zinc-800 dark:hover:bg-zinc-750">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="mr-2 h-4 w-4 text-gray-500 dark:text-gray-400">
                            <path fill-rule="evenodd" d="M2 3.75A.75.75 0 0 1 2.75 3h14.5a.75.75 0 0 1 .75.75v11.5a.75.75 0 0 1-.75.75H2.75A.75.75 0 0 1 2 15.25V3.75ZM6.25 6.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm-3.5 0a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm3.5 3.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm-3.5 0a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm3.5 3.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm-3.5 0a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" />
                        </svg>
                        <select
                            v-model="form.config_id"
                            class="absolute inset-0 h-full w-full cursor-pointer opacity-0 focus:outline-none"
                            title="Select Database"
                        >
                            <option value="" disabled>Select Database</option>
                            <option v-for="config in configs" :key="config.id" :value="config.id">
                                {{ config.database }}
                            </option>
                        </select>
                        <span class="max-w-[100px] truncate text-sm font-medium text-gray-700 dark:text-gray-200">
                            {{ configs.find(c => c.id === form.config_id)?.database || 'Select DB' }}
                        </span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="ml-1 h-4 w-4 text-gray-400">
                            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <input
                    v-model="form.message"
                    type="text"
                    placeholder="Ask AI something..."
                    class="flex-1 border-none bg-transparent py-3 pl-2 text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-0 dark:text-white dark:placeholder:text-zinc-500"
                    :disabled="loading"
                    autofocus
                    autocomplete="off"
                />

                <button
                    type="submit"
                    :disabled="loading || !form.message"
                    :class="[
                        'flex h-10 w-10 shrink-0 items-center justify-center rounded-xl transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500/20',
                        form.message 
                            ? 'bg-indigo-600 text-white shadow-md hover:bg-indigo-500' 
                            : 'bg-gray-100 text-gray-400 dark:bg-zinc-800 dark:text-zinc-600'
                    ]"
                >
                    <svg v-if="!loading" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                        <path d="M3.105 2.289a.75.75 0 0 0-.826.95l1.414 4.925A1.5 1.5 0 0 0 5.135 9.25h6.115a.75.75 0 0 1 0 1.5H5.135a1.5 1.5 0 0 0-1.442 1.086l-1.414 4.926a.75.75 0 0 0 .826.95 28.896 28.896 0 0 0 15.293-7.154.75.75 0 0 0 0-1.115A28.897 28.897 0 0 0 3.105 2.289Z" />
                    </svg>
                    <svg v-else class="h-5 w-5 animate-spin p-0.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </form>
             <div v-if="form.errors.message" class="mt-2 text-center text-xs text-red-500">
                {{ form.errors.message }}
            </div>
            <div class="mt-2 text-center text-xs text-gray-400 dark:text-zinc-600">
                AI can make mistakes. Please verify important information.
            </div>
        </div>
    </div>
</template>
