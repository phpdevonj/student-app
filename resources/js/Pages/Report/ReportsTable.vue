<script setup>

import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    reports: Object,
});
console.log(props);

</script>

<template>
    <section class="max-w-full">
        <header class="my-4">
            <h2 class="text-lg font-medium text-gray-900">Reports</h2>
        </header>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Subject
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Report Start Time
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Report End Time
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="report in reports.data"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ report.subject_name }}
                    </th>
                    <td class="px-6 py-4">
                        {{ report.start_date }}
                    </td>
                    <td class="px-6 py-4">
                        {{ report.end_date }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <Pagination :obj="reports"/>
    </section>
</template>
