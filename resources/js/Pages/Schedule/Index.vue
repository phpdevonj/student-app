<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import ScheduleListTable from "@/Pages/Schedule/Partial/ScheduleListTable.vue";
import ScheduleCreate from "@/Pages/Schedule/Partial/ScheduleCreate.vue";

defineProps({
    schedules: Object,
    students: Object,
    status: String,
});
</script>

<template>
    <Head title="Students"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <ScheduleListTable
                        :schedules="schedules"
                        class="max-w-full"
                    />
                </div>
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <ScheduleCreate class="max-w-full" :students="students" :status="status"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
