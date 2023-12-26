<script setup>
import ApplicationLogo from "./ApplicationLogo.vue";
import EditIcon from "./EditIcon.vue";
import DeleteIcon from "./DeleteIcon.vue";
import { Link } from "@inertiajs/vue3";

defineProps(["book"]);
const emit = defineEmits(["edit", "delete"]);
</script>

<template>
    <div class="p-6 flex flex-row space-x-2">
        <ApplicationLogo v-if="!book.image" class="h-5 w-5" />
        <img
            v-else
            :src="book.image"
            class="aspect-square fill w-16 h-16 object-cover"
        />
        <div class="flex-1">
            <div class="flex justify-between items-center">
                <span class="text-gray-800 text-md">{{ book.name }}</span>
                <small class="ml-2 text-xs text-gray-600">{{
                    new Date(book.created_at).toLocaleString()
                }}</small>
            </div>
            <div class="flex justify-between">
                <p class="mt-1 pl-4 text-xs text-gray-900">
                    {{ book.description }}
                </p>
                <!-- Edit & Delete -->
                <div
                    v-if="$page.props.auth.user.isAdmin"
                    class="flex gap-2 p-2"
                >
                    <EditIcon
                        @on-click="emit('edit', book)"
                        class="w-6 h-6 hover:bg-gray-200 p-1 rounded"
                    />

                    <Link
                        as="button"
                        :href="route('books.destroy', book.id)"
                        method="delete"
                    >
                        <DeleteIcon
                            class="w-6 h-6 hover:bg-gray-200 p-1 rounded"
                        />
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
