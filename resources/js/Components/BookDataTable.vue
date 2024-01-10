<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Link } from "@inertiajs/vue3";
import EditIcon from "./EditIcon.vue";
import DeleteIcon from "./DeleteIcon.vue";
import InputField from "./InputField.vue";

const search = ref("");
const form = useForm({
    book_id: null,
    loan_date: null,
    due_date: null,
    days: null,
});

function updateDays(value) {
    console.log(value);
    form.days = value;
}

const props = defineProps(["books"]);
const emit = defineEmits(["edit", "delete", "borrowBook"]);

const headers = [
    { title: "Name", value: "name" },
    { title: "Cover", value: "image" },
    { title: "Publisher", value: "publisher" },
    { title: "Category", value: "category" },
    { title: "Pages", value: "pages" },
    { title: "Synopsis", value: "description" },
    { title: "Status", value: "status" },
    { title: "", value: "id" },
];
</script>

<template>
    <v-card flat>
        <v-card-title class="d-flex align-center pe-2">
            {{
                $page.props.auth.user.isAdmin
                    ? "All Books"
                    : "Find a Book & Borrow"
            }}
            <span> </span>
            <v-spacer></v-spacer>

            <v-text-field
                v-model="search"
                prepend-inner-icon="mdi-magnify"
                density="compact"
                label="Search"
                single-line
                flat
                hide-details
                variant="solo-filled"
            ></v-text-field>
        </v-card-title>

        <v-divider></v-divider>
        <v-data-table v-model:search="search" :items="books" :headers="headers">
            <template v-slot:item.image="{ item }">
                <v-card class="my-2" elevation="2" rounded>
                    <v-img :src="item.image" height="64" cover></v-img>
                </v-card>
            </template>
            <template v-slot:item.status="{ item }">
                <div class="text-end">
                    <v-chip
                        :color="item.loans.length > 0 ? 'red' : 'green'"
                        :text="item.loans.length > 0 ? 'ON LOAN' : 'AVAILABLE'"
                        class="text-uppercase"
                        label
                        size="small"
                    ></v-chip>
                </div>
            </template>
            <template v-slot:item.id="{ item }">
                <form @submit.prevent="" class="flex flex-row">
                    <div
                        v-if="!$page.props.auth.user.isAdmin"
                        class="flex items-center"
                    >
                        <PrimaryButton
                            class="scale-90 !h-10"
                            type="submit"
                            @onClick="emit('borrowBook', item.id)"
                            >Borrow</PrimaryButton
                        >
                    </div>
                    <PrimaryButton
                        v-if="$page.props.auth.user.isAdmin"
                        @onClick="emit('edit', item)"
                        class="scale-90"
                        ><EditIcon class="w-6 h-6"
                    /></PrimaryButton>
                    <Link
                        as="button"
                        :href="route('books.destroy', item.id)"
                        method="delete"
                    >
                        <PrimaryButton
                            v-if="$page.props.auth.user.isAdmin"
                            :disabled="!item.available"
                            :class="
                                !item.available
                                    ? 'scale-90'
                                    : 'scale-90 !bg-red-600'
                            "
                            ><DeleteIcon class="w-6 h-6"
                        /></PrimaryButton>
                    </Link>
                </form>
            </template>
        </v-data-table>
    </v-card>
</template>
