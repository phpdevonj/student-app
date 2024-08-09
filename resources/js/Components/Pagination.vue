<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    obj: Object | Array,
});
</script>

<template>
    <div class="w-full justify-end flex my-4" v-if="obj.total > obj.per_page">
        <nav aria-label="Page navigation example mt-2">
            <ul class="inline-flex -space-x-px text-sm">
                <template v-for="link in obj.links">
                    <li v-if="link.label.includes('rev')">
                        <Link :href="link.url"
                              class=" border-e-0 rounded-s-lg flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            Previous
                        </Link>
                    </li>
                    <li v-else-if="link.label.includes('ext')">
                        <Link :href="link.url"
                              class="rounded-e-lg flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            Next
                        </Link>
                    </li>
                    <li v-else-if="link.label != obj.current_page">
                        <Link :href="link.url"
                              class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            {{ link.label }}
                        </Link>
                    </li>

                    <li v-else>
                        <Link :href="link.url"
                              :aria-current="link.active ? 'page':''"
                              class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 dark:border-gray-700 dark:bg-gray-700 dark:text-white">
                            {{ link.label }}
                        </Link>
                    </li>
                </template>
            </ul>
        </nav>
    </div>
</template>
