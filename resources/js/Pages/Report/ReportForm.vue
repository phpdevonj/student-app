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
    form.post(route('repost.store'), {
        onSuccess: () => form.reset()
    });
};

</script>

<template>
    <section>
        <header class="my-4">
            <h2 class="text-lg font-medium text-gray-900">Student Reports</h2>
        </header>

        <input type="file"  />
        <button >Upload</button>

    </section>
</template>
