<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";

const search = ref("");
const form = useForm({
    book_id: null,
    loan_date: null,
    due_date: null,
});

const props = defineProps(["books"]);

function formatDateToSQLDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0"); // Months are zero-indexed
    const day = String(date.getDate()).padStart(2, "0");

    return `${year}-${month}-${day}`;
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

    // console.log(form);

    // book book
    form.post(route("loans.store"));
}

const headers = [
    { title: "Name", value: "name" },
    { title: "Cover", value: "image" },
    { title: "Publisher", value: "publisher" },
    { title: "Category", value: "category" },
    { title: "Pages", value: "pages" },
    { title: "Synopsis", value: "description" },
    { title: "", value: "id" },
];
</script>

<template>
    <v-card flat>
        <v-card-title class="d-flex align-center pe-2">
            Find a Book & Borrow for a week.
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
        <v-data-table v-model:search="search" :items="books" :headers="headers">
            <template v-slot:item.image="{ item }">
                <v-card class="my-2" elevation="2" rounded>
                    <v-img :src="item.image" height="64" cover></v-img>
                </v-card>
            </template>
            <template v-slot:item.id="{ item }">
                <form @submit.prevent="handleBorrowBook(item.id)">
                    <PrimaryButton type class="scale-90">Borrow</PrimaryButton>
                </form>
            </template>
        </v-data-table>
    </v-card>
</template>
