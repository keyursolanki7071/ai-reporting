<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import { ref } from 'vue';
import axios from 'axios';
import AppLayout from '../../components/AppLayout.vue';

const form = useForm({
    host: '',
    port: 3306,
    database: '',
    username: '',
    password: '',
    is_active: true,
});

const testingConnection = ref(false);
const testMessage = ref('');
const testStatus = ref<'success' | 'error' | null>(null);

const testConnection = async () => {
    testingConnection.value = true;
    testMessage.value = '';
    testStatus.value = null;

    try {
        const response = await axios.post(route('database-configs.test-connection'), {
            host: form.host,
            port: form.port,
            database: form.database,
            username: form.username,
            password: form.password,
        });
        testStatus.value = 'success';
        testMessage.value = response.data.message;
    } catch (error: any) {
        testStatus.value = 'error';
        testMessage.value = error.response?.data?.message || 'Connection failed';
    } finally {
        testingConnection.value = false;
    }
};

const submit = () => {
    form.post(route('database-configs.store'));
};
</script>

<template>
    <AppLayout>
        <Head title="Create Database Configuration" />

        <div class="max-w-3xl mx-auto">
            <div class="md:flex md:items-center md:justify-between mb-8">
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight dark:text-white">Create Configuration</h2>
                </div>
            </div>

            <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2 dark:bg-zinc-900 dark:ring-zinc-800">
                <div class="px-4 py-6 sm:p-8">
                    <form @submit.prevent="submit" class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label for="host" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Host</label>
                            <div class="mt-2">
                                <input
                                    type="text"
                                    name="host"
                                    id="host"
                                    v-model="form.host"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500"
                                    required
                                />
                                <p v-if="form.errors.host" class="mt-2 text-sm text-red-600">{{ form.errors.host }}</p>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="port" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Port</label>
                            <div class="mt-2">
                                <input
                                    type="number"
                                    name="port"
                                    id="port"
                                    v-model="form.port"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500"
                                    required
                                />
                                <p v-if="form.errors.port" class="mt-2 text-sm text-red-600">{{ form.errors.port }}</p>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="database" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Database Name</label>
                            <div class="mt-2">
                                <input
                                    type="text"
                                    name="database"
                                    id="database"
                                    v-model="form.database"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500"
                                    required
                                />
                                <p v-if="form.errors.database" class="mt-2 text-sm text-red-600">{{ form.errors.database }}</p>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="username" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Username</label>
                            <div class="mt-2">
                                <input
                                    type="text"
                                    name="username"
                                    id="username"
                                    v-model="form.username"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500"
                                    required
                                />
                                <p v-if="form.errors.username" class="mt-2 text-sm text-red-600">{{ form.errors.username }}</p>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="password" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100">Password</label>
                            <div class="mt-2">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    v-model="form.password"
                                    class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500"
                                />
                                <p v-if="form.errors.password" class="mt-2 text-sm text-red-600">{{ form.errors.password }}</p>
                            </div>
                        </div>

                        <div class="sm:col-span-3 pt-8">
                            <div class="relative flex gap-x-3">
                                <div class="flex h-6 items-center">
                                    <input
                                        id="is_active"
                                        name="is_active"
                                        type="checkbox"
                                        v-model="form.is_active"
                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-zinc-700 dark:bg-zinc-800 dark:ring-offset-zinc-900"
                                    />
                                </div>
                                <div class="text-sm leading-6">
                                    <label for="is_active" class="font-medium text-gray-900 dark:text-gray-100">Active Configuration</label>
                                    <p class="text-gray-500 dark:text-gray-400">Enable this configuration for use in reporting.</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="flex items-center justify-between gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8 dark:border-zinc-800">
                     <div class="flex items-center gap-x-4">
                        <button
                            type="button"
                            @click="testConnection"
                            :disabled="testingConnection || !form.host || !form.username"
                            class="rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 disabled:opacity-50 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:hover:bg-zinc-700"
                        >
                            <span v-if="testingConnection">Testing...</span>
                            <span v-else>Test Connection</span>
                        </button>
                        
                        <span v-if="testMessage" :class="{'text-green-600': testStatus === 'success', 'text-red-600': testStatus === 'error'}" class="text-sm font-medium">
                            {{ testMessage }}
                        </span>
                    </div>

                    <div class="flex items-center gap-x-6">
                        <Link :href="route('database-configs.index')" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700 dark:text-gray-100 dark:hover:text-gray-300">Cancel</Link>
                        <button
                            @click="submit"
                            type="submit"
                            :disabled="form.processing"
                            class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
