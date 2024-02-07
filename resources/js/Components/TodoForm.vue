<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    item: '',
});

const submit = () => {
    form.post(route('todo.create'), {
        onFinish: () => {
            console.info('reset')
            // form.reset()
            form.item = ''
        }
    });
};
</script>

<style>
    form {
        margin: 20px;
    }
</style>

<template>
    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <form @submit.prevent="submit">
        <div>
            <InputLabel for="item" value="Item" />

            <TextInput
                id="item"
                type="text"
                class="mt-1 block w-full"
                v-model="form.item"
                required
                autofocus
            />

            <InputError class="mt-2" :message="form.errors.item" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Add
            </PrimaryButton>
        </div>
    </form>
</template>
