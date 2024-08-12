<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    status: String,
});

const form = useForm({
    file: null, // Initialize file data
});

const fileInput = ref(null);

const handleFileChange = (e) => {
    form.file = e.target.files[0];
};

const submit = () => {
    form.post(route('report.upload'), {
        onSuccess: () => {
            form.reset();
            fileInput.value.value = null; // Reset the file input
        }
    });
};

</script>

<template>
    <section>
        <header class="my-4">
            <h2 class="text-lg font-medium text-gray-900">Import Sample Docx</h2>
        </header>

        <form @submit.prevent="submit" enctype="multipart/form-data">
            <div class="flex items-center justify-end mt-4">
                <input
                    type="file"
                    @change="handleFileChange"
                    ref="fileInput"
                />
                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Import
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>
