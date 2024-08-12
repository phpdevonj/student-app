<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

defineProps({
    reportCard: Object,
});
</script>

<template>
    <Head title="Report Card"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Report Card</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <h2>Student Improvement Report Card</h2>
                    <p>Student name: {{ reportCard.student_full_name }}</p>
                    <p>Session date: {{ reportCard.session_date }}</p>
                    <p>Report card for period: {{ reportCard.target_start_date }} to {{ reportCard.target_end_date }}</p>
                    <p>Target: {{ reportCard.target }}</p>
                    <p>Achieved: {{ reportCard.session_rating }}</p>
                    <p>Lorem Ipsum is simply {{ reportCard.student_full_name }} text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since {{ reportCard.session_date }}, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularized in the 1960s with the release of Letraset sheets containing the achievement level {{ reportCard.session_rating }} out of {{ reportCard.target }}, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
