<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BookForm from "@/Components/BookForm.vue";
import ModalContainer from "@/Components/ModalContainer.vue";
import UserDataTable from "@/Components/UserDataTable.vue";

import { ref } from "vue";

import { Head, Link, useForm } from "@inertiajs/vue3";
import { provide } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Book from "@/Components/Book.vue";

const modalIsOpen = ref(false);
const editing = ref(false);
const deleteModalIsOpen = ref(false);
const selectedBook = ref({});

const props = defineProps(["users"]);

const form = useForm({
    id: null,
    isAdmin: null,
});
provide("modalIsOpen", modalIsOpen);

function handleMakeUserAdmin(user) {
    form.id = user.id;
    form.isAdmin = true;

    form.post(route("users.updateIsAdmin"));
}
function deleteUser(user) {
    form.id = user.id;
    form.delete(route("profile.destroy"));
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
    <Head title="Users" />
    <AuthenticatedLayout>
        <div>
            <div v-if="$page.props.auth.user.isAdmin" class="">
                <div class="flex w-full bg-gray-100 justify-end px-7 py-3 mt-7">
                    <Link href="/register" as="button">
                        <PrimaryButton>Add User</PrimaryButton>
                    </Link>
                </div>
            </div>

            <div class="data-table">
                <UserDataTable
                    :users="users"
                    @edit="handleMakeUserAdmin"
                    @delete="deleteUser"
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
        </div>
    </AuthenticatedLayout>
</template>
