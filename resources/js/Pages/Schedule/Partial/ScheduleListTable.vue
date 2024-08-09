<script setup>


import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    schedules: Object,
});
</script>

<template>
    <section class="max-w-full">
        <header class="my-4">
            <h2 class="text-lg font-medium text-gray-900">Schedules</h2>
        </header>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Schedule Start Time
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Schedule End Time
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="schedule in schedules.data"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ schedule.title }}
                    </th>
                    <td class="px-6 py-4">
                        {{ schedule.start_date_time }}
                    </td>
                    <td class="px-6 py-4">
                        {{ schedule.end_date_time }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <Pagination :obj="schedules"/>
    </section>
</template>
