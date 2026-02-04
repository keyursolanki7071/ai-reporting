<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { computed } from 'vue';

const page = usePage();
const currentRoute = computed(() => page.url);

const navigation = [
    { name: 'Home', href: route('home'), icon: 'HomeIcon', current: currentRoute.value === '/' },
    { name: 'Database Configs', href: route('database-configs.index'), icon: 'DatabaseIcon', current: currentRoute.value.startsWith('/database-configs') },
];
</script>

<template>
    <div class="min-h-screen bg-gray-50 dark:bg-zinc-950">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 z-50 flex w-72 flex-col">
            <!-- Sidebar Component -->
            <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4 dark:border-zinc-800 dark:bg-zinc-900">
                <div class="flex h-16 shrink-0 items-center">
                    <h1 class="text-xl font-bold bg-gradient-to-r from-indigo-500 to-purple-500 bg-clip-text text-transparent">AI Reporting</h1>
                </div>
                <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <li v-for="item in navigation" :key="item.name">
                                    <Link
                                        :href="item.href"
                                        :class="[
                                            item.current
                                                ? 'bg-gray-50 text-indigo-600 dark:bg-zinc-800 dark:text-indigo-400'
                                                : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-zinc-800 dark:hover:text-white',
                                            'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 transition-all duration-200'
                                        ]"
                                    >
                                        <!-- Icons (Inline SVGs) -->
                                        <svg v-if="item.icon === 'HomeIcon'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                        </svg>
                                        <svg v-else-if="item.icon === 'DatabaseIcon'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                                        </svg>
                                        {{ item.name }}
                                    </Link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="pl-72">
            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
