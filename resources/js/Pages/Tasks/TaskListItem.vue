<script setup>
import {PencilIcon} from "@heroicons/vue/solid";
import {computed, nextTick, ref} from "vue";
import {useForm, Link} from '@inertiajs/vue3';
import {store} from "@/store";

const props = defineProps({
    task: Object
});

const inputTitleRef = ref();
const isShowingForm = computed(() => props.task.id === store.value.editingTaskId);
const form = useForm({
    title: props.task.title,
    list_id: props.task.list_id,
    project_id: props.task.project_id,
});

async function showForm() {
    store.value.editingTaskId = props.task.id;
    await nextTick();
    inputTitleRef.value.focus();
}

function onSubmit() {
    form.put(route('projects.tasks.update', {project: props.task.project_id, task: props.task.id}), {
        onSuccess: () => store.value.editingTaskId = null
    });
}
</script>

<template>
    <li>
        <div
            class="group relative bg-white shadow rounded-md border-b border-gray-300 hover:bg-gray-50"
        >
            <form
                class="p-2.5"
                v-if="isShowingForm"
                @keydown.esc="store.editingTaskId = null"
                @submit.prevent="onSubmit()"
            >
        <textarea
            ref="inputTitleRef"
            v-model="form.title"
            class="block w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-blue-400 focus:ring-blue-400"
            placeholder="Enter task title..."
            rows="3"
            @keydown.enter.prevent="onSubmit()"
        ></textarea>

                <div class="mt-2 space-x-2">
                    <button
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-500 rounded-md shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:outline-none"
                        type="submit"
                    >Save task
                    </button>
                    <button
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-black rounded-md focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:outline-none"
                        type="button"
                        @click="store.editingTaskId = null"
                    >Cancel
                    </button>
                </div>
            </form>

            <template v-if="!isShowingForm">
                <Link
                    class="text-sm block p-2.5"
                    :href="route('projects.tasks.index', {project: task.project_id, task: task.id})"
                    preserve-state
                >
                    {{ task.title }}
                </Link>

                <button
                    class="hidden absolute top-1 right-1 w-8 h-8 bg-gray-50 group-hover:grid place-content-center rounded-md text-gray-600 hover:text-black hover:bg-gray-200"
                    @click="showForm()"
                >
                    <PencilIcon class="w-5 h-5"/>
                </button>
            </template>
        </div>
    </li>
</template>
