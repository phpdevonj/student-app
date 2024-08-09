<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import AvailabilityTable from "@/Pages/Availability/Partial/AvailabilityTable.vue";

defineProps({
    availability: Object,
});
</script>

<template>
    <Head title="Students"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Availability</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <AvailabilityTable
                        :availability="availability"
                        class="max-w-full"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
