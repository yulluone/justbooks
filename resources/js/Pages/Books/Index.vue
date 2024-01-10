<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BookForm from "@/Components/BookForm.vue";
import ModalContainer from "@/Components/ModalContainer.vue";
import BookDataTable from "@/Components/BookDataTable.vue";
import { useForm } from "@inertiajs/vue3";

import { Head } from "@inertiajs/vue3";

import { ref } from "vue";
import { provide } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Book from "@/Components/Book.vue";

const modalIsOpen = ref(false);
const editing = ref(false);
const deleteModalIsOpen = ref(false);
const selectedBook = ref({});

const props = defineProps(["books"]);

provide("modalIsOpen", modalIsOpen);

const borrorBookModalIsOpen = ref(false);

const form = useForm({
    book_id: null,
    loan_date: null,
    due_date: null,
    days: null,
});

function toggleBookFormModal(value) {
    modalIsOpen.value = value;
    if (!value) {
        selectedBook.value = {};
    }
}

function toggleBorrowBookModal(id) {
    borrorBookModalIsOpen.value = id ? true : false;
    form.book_id = id ? id : null;
}

function formatDateToSQLDate(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0"); // Months are zero-indexed
    const day = String(date.getDate()).padStart(2, "0");

    return `${year}-${month}-${day}`;
}

function handleBorrowBook() {
    const today = new Date();
    const loanDate = formatDateToSQLDate(today);
    const aWeekFromNow = new Date();
    aWeekFromNow.setDate(today.getDate() + form.days);
    const dueDate = formatDateToSQLDate(aWeekFromNow);

    //set form data
    form.loan_date = loanDate;
    form.due_date = dueDate;

    // borrow book
    form.post(route("loans.store"));

    // close modal
    toggleBorrowBookModal(null);
}

function openEditModal(book) {
    selectedBook.value = book;
    editing.value = true;
    toggleBookFormModal(true);
}

function openDeleteModal(book) {
    selectedBook.value = book;
    deleteModalIsOpen.value = true;
}
</script>

<template>
    <Head title="Books" />
    <AuthenticatedLayout>
        <div>
            <div v-if="$page.props.auth.user.isAdmin" class="">
                <div class="flex w-full bg-gray-100 justify-end px-7 py-3 mt-7">
                    <PrimaryButton @click="toggleBookFormModal(true)"
                        >Add Book</PrimaryButton
                    >
                </div>
            </div>

            <div class="data-table">
                <BookDataTable
                    :books="books"
                    @edit="openEditModal"
                    @delete="openDeleteModal"
                    @borrowBook="toggleBorrowBookModal"
                />
            </div>

            <!-- <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
										<Book
														v-for="book in books"
														:key="book.id"
														:book="book"
														@edit="openEditModal"
														@delete="openDeleteModal"
										/>
						</div> -->

            <ModalContainer
                v-if="$page.props.auth.user.isAdmin"
                id="book-form-modal"
                :show="modalIsOpen"
                @close="toggleBookFormModal(false)"
            >
                <BookForm :book="selectedBook" :editing="editing" />
            </ModalContainer>

            <ModalContainer
                id="borrow-book-modal"
                :show="borrorBookModalIsOpen"
                @close="toggleBorrowBookModal(null)"
            >
                <div class="flex justify-center items-center">
                    <div class="w-1/2">
                        <!-- enter number of days -->
                        <div class="flex flex-col">
                            <label
                                for="days"
                                class="text-sm font-semibold text-gray-600"
                                >Enter number of days. Max 30</label
                            >
                            <input
                                type="number"
                                name="days"
                                id="days"
                                v-model="form.days"
                                class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring focus:ring-blue-300"
                            />
                        </div>

                        <div class="flex justify-end mt-4">
                            <PrimaryButton
                                @click="toggleBorrowBookModal(false)"
                                class="mr-2"
                            >
                                Cancel
                            </PrimaryButton>
                            <PrimaryButton
                                @click="handleBorrowBook"
                                :disabled="!form.days || form.days > 30"
                            >
                                Confirm
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </ModalContainer>
        </div>
    </AuthenticatedLayout>
</template>
