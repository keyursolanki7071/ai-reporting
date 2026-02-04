<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AppLayout from '../../components/AppLayout.vue';
import { PencilSquareIcon, TrashIcon, PlusIcon } from '@heroicons/vue/20/solid'; // Assuming Heroicons, but will use SVGs if not available. Actually, I'll inline SVGs to be safe as per previous check.

defineProps<{
    configs: Array<{
        id: number;
        host: string;
        port: number;
        database: string;
        username: string;
        is_active: boolean;
    }>;
}>();

const deleteConfig = (id: number) => {
    if (confirm('Are you sure you want to delete this configuration?')) {
        router.delete(route('database-configs.destroy', id));
    }
};
</script>

<template>
    <AppLayout>
        <Head title="Database Configurations" />

        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Database Configurations</h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Manage your database connections for dynamic reporting.</p>
                </div>
                <Link
                    :href="route('database-configs.create')"
                    class="inline-flex items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors duration-200"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    New Config
                </Link>
            </div>

            <!-- Empty State -->
            <div v-if="configs.length === 0" class="flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-zinc-700 dark:hover:border-zinc-600">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-gray-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694-4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900 dark:text-white">No configs found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating a new database configuration.</p>
                <div class="mt-6">
                    <Link
                        :href="route('database-configs.create')"
                        class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="-ml-0.5 mr-1.5 h-5 w-5">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        New Config
                    </Link>
                </div>
            </div>

            <!-- List -->
            <div v-else class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5 dark:bg-zinc-900 dark:ring-zinc-800">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-800">
                    <thead class="bg-gray-50 dark:bg-zinc-800/50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Host / Database</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Username</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-6">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                        <tr v-for="config in configs" :key="config.id" class="group hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors duration-150">
                            <td class="whitespace-nowrap py-4 pl-6 pr-3">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ config.host }}:{{ config.port }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ config.database }}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-600 dark:text-gray-300">
                                {{ config.username }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <span
                                    v-if="config.is_active"
                                    class="inline-flex items-center gap-x-1.5 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-500/10 dark:text-green-400"
                                >
                                    <svg class="h-1.5 w-1.5 fill-green-500" viewBox="0 0 6 6" aria-hidden="true"><circle cx="3" cy="3" r="3" /></svg>
                                    Active
                                </span>
                                <span
                                    v-else
                                    class="inline-flex items-center gap-x-1.5 rounded-full bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600 dark:bg-zinc-700 dark:text-zinc-400"
                                >
                                    <svg class="h-1.5 w-1.5 fill-gray-400" viewBox="0 0 6 6" aria-hidden="true"><circle cx="3" cy="3" r="3" /></svg>
                                    Inactive
                                </span>
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-x-4">
                                    <Link :href="route('database-configs.edit', config.id)" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 flex items-center gap-1 group-hover:opacity-100 transition-opacity">
                                        Edit
                                    </Link>
                                    <button @click="deleteConfig(config.id)" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 flex items-center gap-1 group-hover:opacity-100 transition-opacity">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
