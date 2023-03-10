<script setup>
import {computed, defineProps, watch} from 'vue'
import {Dialog, DialogPanel, TransitionChild, TransitionRoot,} from '@headlessui/vue';
import {TrashIcon} from "@heroicons/vue/solid";
import {Link, useForm, router} from "@inertiajs/vue3";

const props = defineProps({
    task: Object
});

const isOpen = computed(() => !!props.task);

const form = useForm({
    list_id: props.task?.list_id,
    project_id: props.task?.project_id,
    title: props.task?.title,
    description: props.task?.description,
    redirectUrl: `/projects/${props.task?.project_id}/tasks`
});

watch(() => props.task, (task) => {
    if (task) {
        form.list_id = task.list_id;
        form.project_id = task.project_id;
        form.title = task.title;
        form.description = task.description;
        form.redirectUrl = `/projects/${props.task?.project_id}/tasks`
    }
});

function closeModal() {
    router.get(route('projects.tasks.index', {project: props.task.project_id}), {}, {
        preserveState: true
    });
}

function onSubmit() {
    form.put(route('projects.tasks.update', {project: props.task.project_id, task: props.task.id}));
}
</script>

<template>
    <TransitionRoot
        :show="isOpen"
        appear
        as="template"
    >
        <Dialog
            as="div"
            class="relative z-10"
            @close="closeModal"
        >
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-40"/>
            </TransitionChild>

            <div class="overflow-y-auto fixed inset-0">
                <div
                    class="flex justify-center items-start px-4 py-12 min-h-full text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="overflow-hidden w-full max-w-3xl text-left align-middle bg-white rounded-md shadow-xl transition-all transform"
                        >
                            <div class="flex flex-col sm:flex-row">
                                <form
                                    class="flex-1 p-5"
                                    @submit.prevent="onSubmit"
                                >
                                    <div>
                                        <label
                                            class="sr-only"
                                            for="title"
                                        >Title</label>
                                        <textarea
                                            id="title"
                                            v-model="form.title"
                                            class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400"
                                            name="title"
                                            rows="1"
                                        ></textarea>
                                    </div>

                                    <div class="mt-4">
                                        <label
                                            class="inline-block mb-1 text-sm font-semibold text-gray-700"
                                            for="description"
                                        >Description</label>
                                        <textarea
                                            id="description"
                                            v-model="form.description"
                                            class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400"
                                            name="description"
                                            rows="4"
                                        ></textarea>
                                    </div>

                                    <div class="mt-2 space-x-2">
                                        <button
                                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md shadow-sm hover:bg-indigo-500 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:outline-none"
                                            type="submit"
                                        >Save task
                                        </button>
                                        <button
                                            class="px-4 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-black focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:outline-none"
                                            type="button"
                                            @click="closeModal()"
                                        >Cancel
                                        </button>
                                    </div>
                                </form>
                                <div class="p-5 bg-gray-100 sm:w-48">
                                    <h3 class="mb-2 text-xs font-semibold tracking-wide text-gray-500 uppercase">
                                        Actions
                                    </h3>
                                    <Link
                                        :href="route('projects.tasks.delete', {project: task.project_id, list: task.list_id, task: task.id})"
                                        method="delete"
                                        as="button"
                                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md shadow-sm hover:bg-gray-300 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:outline-none"
                                    >
                                        <TrashIcon class="mr-1 -ml-1 w-4 h-4 shrink-0"/>
                                        <span>Delete task</span>
                                    </Link>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
