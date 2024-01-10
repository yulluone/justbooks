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
const emit = defineEmits(["edit", "delete"]);

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
    aWeekFromNow.setDate(today.getDate() + form.days);
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
            Find a Book & Borrow
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
                <form @submit.prevent="" class="flex flex-row">
                    <div
                        v-if="!$page.props.auth.user.isAdmin"
                        class="flex items-center"
                    >
                        <input
                            :id="item.id"
                            placeholder="Days"
                            type="number"
                            class="w-20 h-10 rounded border border-gray-800"
                            required
                            v-model="form.days"
                        />

                        <PrimaryButton
                            class="scale-90 !h-10"
                            type="submit"
                            @onClick="handleBorrowBook(item.id)"
                            :disabled="!form.days || form.days > 30"
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
                            class="scale-90 !bg-red-600"
                            ><DeleteIcon class="w-6 h-6"
                        /></PrimaryButton>
                    </Link>
                </form>
            </template>
        </v-data-table>
    </v-card>
</template>
