<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    submitUrl: string;
}>();

const form = useForm({
    message: '',
});

const loading = ref(false);

const submit = () => {
    loading.value = true;
    form.post(props.submitUrl, {
        onSuccess: () => {
            form.reset();
        },
        onFinish: () => {
            loading.value = false;
        },
        preserveUrl: true
    });
};
</script>

<template>
    <footer class="border-t border-gray-200 bg-white px-6 py-4 dark:border-zinc-800 dark:bg-zinc-900">
        <div class="mx-auto max-w-3xl">
            <form @submit.prevent="submit" class="relative">
                <input
                    v-model="form.message"
                    type="text"
                    placeholder="Ask for a report (e.g., 'Show total orders by month')"
                    class="w-full rounded-lg border border-gray-300 bg-gray-50 py-3 pr-12 pl-4 text-sm text-gray-900 placeholder:text-gray-500 focus:border-black focus:ring-1 focus:ring-black focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder:text-zinc-500 dark:focus:border-white dark:focus:ring-white"
                    :disabled="loading"
                />
                <button
                    type="submit"
                    class="absolute top-1/2 right-2 -translate-y-1/2 rounded-md p-1.5 text-gray-500 hover:text-gray-900 focus:outline-none dark:text-gray-400 dark:hover:text-white"
                    :disabled="loading"
                >
                    <svg v-if="!loading" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    <svg v-else class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
                    <div v-if="form.errors.message" class="absolute -top-6 left-0 text-xs text-red-500">
                    {{ form.errors.message }}
                </div>
            </form>
        </div>
    </footer>
</template>
