<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm, Link } from "@inertiajs/vue3";
import EditIcon from "./EditIcon.vue";
import DeleteIcon from "./DeleteIcon.vue";

const search = ref("");
const form = useForm({
    book_id: null,
    loan_date: null,
    due_date: null,
});

const props = defineProps(["users"]);
const emit = defineEmits(["edit", "delete"]);

function formatDateToSQLDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0"); // Months are zero-indexed
    const day = String(date.getDate()).padStart(2, "0");

    return `${year}-${month}-${day}`;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString();
}

function handleBorrowBook(id) {
    const today = new Date();
    const loanDate = formatDateToSQLDate(today);
    const aWeekFromNow = new Date();
    aWeekFromNow.setDate(today.getDate() + 7);
    const dueDate = formatDateToSQLDate(aWeekFromNow);

    //set form data
    form.book_id = id;
    form.loan_date = loanDate;
    form.due_date = dueDate;

    // book book
    form.post(route("loans.store"));
}

const headers = [
    { title: "Name", value: "name" },
    { title: "Email", value: "email" },
    { title: "", value: "id" },
];
</script>

<template>
    <v-card flat>
        <v-card-title class="d-flex align-center pe-2">
            Manage Users.
            <span></span>
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
        <v-data-table v-model:search="search" :items="users" :headers="headers">
            <template v-slot:item.image="{ item }">
                <v-card class="my-2" elevation="2" rounded>
                    <v-img :src="item.image" height="64" cover></v-img>
                </v-card>
            </template>
            <template v-slot:item.id="{ item }">
                <form @submit.prevent="" class="flex flex-row">
                    <PrimaryButton
                        v-if="!$page.props.auth.user.isAdmin"
                        type
                        class="scale-90"
                        @onClick="handleBorrowBook(item.id)"
                        >Borrow</PrimaryButton
                    >
                    <!-- <PrimaryButton
                        v-if="$page.props.auth.user.isAdmin"
                        @onClick="emit('edit', item)"
                        class="scale-90"
                        >Make Admin</PrimaryButton
                    > -->

                    <PrimaryButton
                        @onClick="emit('delete', item)"
                        v-if="$page.props.auth.user.isAdmin"
                        class="scale-90 !bg-red-600"
                        ><DeleteIcon class="w-6 h-6"
                    /></PrimaryButton>
                </form>
            </template>
        </v-data-table>
    </v-card>
</template>
