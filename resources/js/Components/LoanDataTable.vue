<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";

const search = ref("");
const error = ref("");
const form = useForm({
    id: null,
    due_date: null,
    extended: null,
    extension_date: null,
    status: null,
    return_date: null,
    book_id: null,
});

const props = defineProps(["loans"]);

function formatDateToSQLDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0"); // Months are zero-indexed
    const day = String(date.getDate()).padStart(2, "0");

    return `${year}-${month}-${day}`;
}

function extendDateByAWeek(sqlDate) {
    const parsedDate = new Date(sqlDate);
    parsedDate.setDate(parsedDate.getDate() + 7);
    // Returning the extended date in SQL format (YYYY-MM-DD)
    const extendedDate = formatDateToSQLDate(parsedDate);
    return extendedDate;
}

function handleReceiveBook(item) {
    // console.log(item);
    // return;
    const today = new Date();

    form.id = item.id;
    form.book_id = item.book_id;
    form.return_date = true;
    form.extension_date = formatDateToSQLDate(today);

    form.put(route("loan.receive"));
}
function handleExtendLoan(item) {
    const today = new Date();

    form.id = item.id;
    form.due_date = extendDateByAWeek(item.due_date);
    form.return_date = formatDateToSQLDate(today);

    form.put(route("loan.extend"));
    // form.put(route("loans.update", item.id));
}

function handleLoanApproval(item) {
    form.id = item.id;
    form.put(route("loan.approve"));
}

function handleLoanDenial(item) {
    form.id = item.id;
    form.put(route("loan.deny"));
}

const headers = [
    { title: "Cover", value: "book.image", sortable: true },
    { title: "Name", value: "book.name", sortable: true },
    { title: "Loan Date", value: "loan_date" },
    { title: "Due Date", value: "due_date" },
    { title: "Status", value: "status", sortable: true },
    { title: "", value: "id" },
];
</script>

<template>
    <v-card flat>
        <v-card-title class="d-flex align-center pe-2">
            Your Book Loans
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

        <v-data-table v-model:search="search" :items="loans" :headers="headers">
            <template v-slot:item.book.image="{ item }">
                <v-card class="my-2" elevation="2" rounded>
                    <v-img :src="item.book.image" height="160" cover></v-img>
                </v-card>
            </template>
            <template v-slot:item.status="{ item }">
                <div class="text-end">
                    <v-chip
                        :color="
                            item.status == 'active'
                                ? 'green'
                                : item.status == 'returned'
                                ? 'blue'
                                : item.status == 'pending'
                                ? 'orange'
                                : 'red'
                        "
                        :text="item.status"
                        class="text-uppercase"
                        label
                        size="small"
                    ></v-chip>
                </div>
            </template>
            <template v-slot:item.id="{ item }">
                <form @submit.prevent="">
                    <PrimaryButton
                        v-if="
                            !$page.props.auth.user.isAdmin &&
                            item.status !== 'pending' &&
                            item.status !== 'returned' &&
                            item.status !== 'denied' &&
                            !item.extended
                        "
                        @onClick="handleExtendLoan(item)"
                        class="scale-90 !bg-amber-900"
                        >Extend 1wk</PrimaryButton
                    >
                    <PrimaryButton
                        v-if="
                            $page.props.auth.user.isAdmin &&
                            item.status == 'active'
                        "
                        @onClick="handleReceiveBook(item)"
                        class="scale-90"
                        >Receive</PrimaryButton
                    >
                    <PrimaryButton
                        v-if="
                            $page.props.auth.user.isAdmin &&
                            item.status == 'pending'
                        "
                        @onClick="handleLoanApproval(item)"
                        class="scale-90"
                        >Approve</PrimaryButton
                    >
                    <PrimaryButton
                        v-if="
                            $page.props.auth.user.isAdmin &&
                            item.status == 'pending'
                        "
                        @onClick="handleLoanDenial(item)"
                        class="scale-90 !bg-amber-900"
                        >Deny</PrimaryButton
                    >
                </form>
            </template>
        </v-data-table>
    </v-card>
</template>
