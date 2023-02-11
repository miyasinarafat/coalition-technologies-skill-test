<script setup>
import {DotsHorizontalIcon, TrashIcon} from '@heroicons/vue/solid';
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue';
import {ref, watch} from "vue";
import TaskListItem from "@/Pages/Tasks/TaskListItem.vue";
import Draggable from "vuedraggable";
import {store} from "@/store";
import {Link, useForm} from '@inertiajs/vue3';
import TaskListItemCreateForm from "@/Pages/Tasks/TaskListItemCreateForm.vue";

const props = defineProps({
    list: Object
});

const form = useForm({
    position: null,
    list_id: null,

});

const listRef = ref();
const cards = ref(props.list.cards);

watch(() => props.list.cards, (newCards) => cards.value = newCards);

function onCardCreated() {
    listRef.value.scrollTop = listRef.value.scrollHeight;
}

function onChange(e) {
    let item = e.added || e.moved;

    if (!item) return;

    let index = item.newIndex;
    let prevCard = cards.value[index - 1];
    let nextCard = cards.value[index + 1];
    let card = cards.value[index];

    let position = card.position;

    if (prevCard && nextCard) {
        position = (prevCard.position + nextCard.position) / 2;
    } else if (prevCard) {
        position = prevCard.position + (prevCard.position / 2);
    } else if (nextCard) {
        position = nextCard.position / 2;
    }

    form.put(route('cards.move', {card: card.id}), {
        position: position,
        list_id: props.list.id
    });
}

</script>
<template>
    <div>
        <div class="flex justify-between items-center px-3 py-2">
            <h3 class="text-sm font-semibold text-gray-700">
                {{ list.title }}
            </h3>
            <Menu
                as="div"
                class="relative z-10"
            >
                <MenuButton class="grid place-content-center w-8 h-8 rounded-md hover:bg-gray-300">
                    <DotsHorizontalIcon class="w-5 h-5"/>
                </MenuButton>

                <transition
                    enter-active-class="transition duration-100 ease-out transform"
                    enter-from-class="opacity-0 scale-90"
                    enter-to-class="opacity-100 scale-100"
                    leave-active-class="transition duration-100 ease-in transform"
                    leave-from-class="opacity-100 scale-100"
                    leave-to-class="opacity-0 scale-90"
                >
                    <MenuItems class="overflow-hidden absolute left-0 mt-2 w-40 bg-white rounded-md border shadow-lg origin-top-left focus:outline-none">
                        <MenuItem v-slot="{active}">
                            <a
                                :class="{'bg-gray-100': active}"
                                class="block px-4 py-2 text-sm text-gray-700"
                                href="#"
                            >Add card</a>
                        </MenuItem>
                        <MenuItem v-slot="{active}">
                            <Link
                                :href="route('projects.tasks.list.delete', {project: props.list.project_id, list: props.list.id})"
                                method="delete"
                                as="button"
                                :class="{'bg-gray-100': active}"
                                class="block px-4 py-2 text-sm text-red-600 w-full text-left"
                            >
                                <span>Delete list</span>
                            </Link>
                        </MenuItem>
                    </MenuItems>
                </transition>
            </Menu>
        </div>
        <div class="flex overflow-hidden flex-col pb-3">
            <div
                ref="listRef"
                class="overflow-y-auto flex-1 px-3"
            >
                <Draggable
                    :disabled="!!store.editingCardId"
                    v-model="cards"
                    class="space-y-3"
                    drag-class="drag"
                    ghost-class="ghost"
                    group="cards"
                    item-key="id"
                    tag="ul"
                    @change="onChange"
                >
                    <template #item="{element}">
                        <TaskListItem :card="element"/>
                    </template>
                </Draggable>
            </div>

            <div class="px-3 mt-3">
                <TaskListItemCreateForm
                    :list="list"
                    @created="onCardCreated()"
                />
            </div>
        </div>
    </div>
</template>
