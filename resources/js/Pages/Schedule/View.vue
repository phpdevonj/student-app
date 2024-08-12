<script setup>

import {Head, useForm} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {onMounted} from "vue";

const props = defineProps({
    schedule: Object,
    error: String,
});

onMounted(() => {
    // TODO: load all data here.
})
let error = ''
const add_rating = (e) => {

    const value = e.target.value

    if (value > 10) {
        alert('The rating must not be greater than 10.')
    }

    const user_id = e.target.getAttribute('data-user')

    const form = useForm({
        'rating': value
    });

    form.post(route('schedule.rating', [props.schedule.id, user_id]));
}

</script>

<template>
    <Head title="Schedule"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ schedule.title }}</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <section class="max-w-full">
                        <header class="my-4">
                            <h2 class="text-lg font-medium text-gray-900">{{ schedule.title }}</h2>
                            <h2 class="text-lg font-medium text-gray-900">{{ error }}</h2>
                        </header>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Rating
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="member in schedule.get_schedule_members"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ member.get_user.name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <input type="number"
                                               :data-user="member.get_user.id"
                                               :value="member.rating"
                                               max="10"
                                               v-on:change="add_rating"
                                               min="1"
                                               class="h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"/>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
