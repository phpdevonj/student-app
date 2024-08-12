<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import ReportForm from "@/Pages/Report/ReportForm.vue";
import UploadReportForm from "@/Pages/Report/UploadReportForm.vue";
import ReportList from "@/Pages/Report/ReportsTable.vue";

defineProps({
    reportCard: Object,
    reports: Object
});

</script>

<template>
    <Head title="Report Card"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UploadReportForm
                        class="max-w-full"
                    />
                    <ReportList
                        :reports="reports"
                        class="max-w-full"
                    />
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
