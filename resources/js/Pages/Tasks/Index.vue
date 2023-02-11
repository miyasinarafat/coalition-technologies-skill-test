<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import TaskList from "@/Pages/Tasks/TaskList.vue";
import TaskListCreateForm from "@/Pages/Tasks/TaskListCreateForm.vue";
import TaskListItemModal from "@/Pages/Tasks/TaskListItemModal.vue";

defineProps({
    project: Object,
    lists: Object,
    task: Object,
    errors: Object,
    status: String,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="sm:flex sm:items-center">
                <div class="sm:flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ project.title }}</h2>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Displaying messages -->
                <div v-if="errors[0]" class="rounded-md bg-red-50 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul role="list" class="list-disc space-y-1 pl-5">
                                    <li v-for="error in errors">{{ error }}</li>
                                </ul>
                            </div>
                            <div class="mt-4">
                                <div class="-mx-2 -my-1.5">
                                    <button @click="errors = []" type="button" class="ml-3 rounded-md bg-red-50 px-2 py-1.5 text-sm font-semibold text-red-800 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-offset-2 focus:ring-offset-red-50">Dismiss</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="status" class="rounded-md bg-green-50 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ status }}</p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button @click="status = ''" type="button" class="inline-flex rounded-md bg-green-50 p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-600 focus:ring-offset-2 focus:ring-offset-green-50">
                                    <span class="sr-only">Dismiss</span>
                                    <!-- Heroicon name: mini/x-mark -->
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-1 overflow-x-auto">
                    <div class="inline-flex h-full items-start px-4 pb-4 space-x-4">
                        <TaskList
                            v-for="list in lists"
                            :key="list.id"
                            :list="list"
                            class="w-72 bg-gray-200 max-h-full flex flex-col rounded-md"
                        >
                        </TaskList>

                        <div class="w-72">
                            <TaskListCreateForm :project="project"/>
                        </div>
                    </div>
                </div>

                <TaskListItemModal :task="task"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
