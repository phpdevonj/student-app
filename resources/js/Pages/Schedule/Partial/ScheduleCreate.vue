<script setup>

import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    status: String,
    students: Object
});

const form = useForm({
    title: '',
    start_date_time: '',
    end_date_time: '',
    students: {}
});

const submit = () => {
    form.post(route('schedule.store'), {
        onSuccess: () => form.reset()
    });
};

</script>

<template>
    <section>
        <header class="my-4">
            <h2 class="text-lg font-medium text-gray-900">Create Schedule</h2>
        </header>

        <form @submit.prevent="submit">

            <div>
                <InputLabel for="title" value="Title"/>

                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    required
                    autocomplete="title"
                />

                <InputError class="mt-2" :message="form.errors.title"/>
            </div>

            <div class="mt-4">
                <InputLabel for="start_date_time" value="Start Date Time"/>

                <TextInput
                    id="start_date_time"
                    type="datetime-local"
                    class="mt-1 block w-full"
                    v-model="form.start_date_time"
                    autocomplete="start_date_time"
                />

                <InputError class="mt-2" :message="form.errors.start_date_time"/>
            </div>

            <div class="mt-4">
                <InputLabel for="end_date_time" value="End Date Time"/>

                <TextInput
                    id="end_date_time"
                    type="datetime-local"
                    class="mt-1 block w-full"
                    v-model="form.end_date_time"
                    autocomplete="end_date_time"
                />

                <InputError class="mt-2" :message="form.errors.end_date_time"/>
            </div>

            <div class="mt-4">
                <InputLabel for="students" value="Students"/>

                <select
                    id="end_date_time"
                    class="mt-1 block w-full"
                    v-model="form.students"
                    multiple="multiple"
                    autocomplete="students"
                >
                    <template v-for="student in students">
                        <option :value="student.id">{{ student.name }}</option>
                    </template>
                </select>

                <InputError class="mt-2" :message="form.errors.students"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>
