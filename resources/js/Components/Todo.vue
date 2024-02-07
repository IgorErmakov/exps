<script setup>
import TodoForm from '@/Components/TodoForm.vue'
import {useForm} from "@inertiajs/vue3";

defineProps({
    items: {
        type: Array,
    },
});

const form = useForm({
    id: 0,
});

const deleteItem = id => {
    form.id = id
    form.delete(route('todo.delete'), {
        onFinish: () => {
            console.info('deleted')
        },
    });
}

const toggleCompleted = item => {
    form.id = item.id
    form.put(route('todo.toggle_completed'))
    item.completed = !item.completed
}

</script>

<style>
.completed {
    text-decoration: line-through;
}
.ms-4 {
    margin-left: 30px;
}
article {
    cursor: pointer;
}
</style>

<template>
    <TodoForm/>

    <h4 class="space-x-2 p-4">Items: {{ items.filter(itm => !itm.completed).length }}</h4>

    <ul class="divide-y divide-slate-100">
        <article class="flex items-start space-x-6 p-6" v-for="item in items" :key="item.id">

            <div class="min-w-0 relative flex-auto">
                <h2 class="font-semibold text-slate-900 truncate pr-20" @click="toggleCompleted(item)" :class="item.completed ? 'completed' : ''">
                    {{item.item}}
                </h2>
                <dl class="mt-2 flex flex-wrap text-sm leading-6 font-medium">
                    <div class="absolute top-0 right-0 flex items-center space-x-1">
                        <dt class="text-sky-500">
                        </dt>
                        <dd>
                            <span class="ms-4" @click="deleteItem(item.id)">
                                X
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </article>

    </ul>
</template>
