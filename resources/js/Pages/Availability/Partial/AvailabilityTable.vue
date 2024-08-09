<script setup>
import {useForm} from "@inertiajs/vue3";

const props = defineProps({
    availability: Object,
});

const availability = props.availability
const weekDays = {
    'monday': !!availability?.monday,
    'tuesday': !!availability?.tuesday,
    'wednesday': !!availability?.wednesday,
    'thursday': !!availability?.thursday,
    'friday': !!availability?.friday,
    'saturday': !!availability?.saturday,
    'sunday': !!availability?.sunday
}

const update_availability = (e) => {
    weekDays[e.target.name] = e.target.checked
    const form = useForm(weekDays);

    form.post(route('availability.update'));
}
</script>

<template>
    <section class="max-w-full">
        <header class="my-4">
            <h2 class="text-lg font-medium text-gray-900">Availability</h2>
        </header>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Days
                    </th>
                    <th scope="col" class="p-4">
                        Availability
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="(is_checked, day) in weekDays"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        {{ day.toUpperCase() }}
                    </td>
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox"
                                   :checked="is_checked"
                                   v-on:change="update_availability"
                                   :name="day"
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="relative overflow-x-auto mt-4">
            <input id="checkbox-table-search-1" type="checkbox"
                   checked
                   disabled
                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
            This indicating available
            <br>
            <input id="checkbox-table-search-1" type="checkbox"
                   disabled
                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
            This indicating not-available
        </div>
    </section>
</template>
