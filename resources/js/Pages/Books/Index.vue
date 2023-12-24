<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BookForm from "@/Components/BookForm.vue";
import ModalContainer from "@/Components/ModalContainer.vue";
import Modal from "@/Components/Modal.vue";

import { Head } from "@inertiajs/vue3";

import { ref } from "vue";
import { provide } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Book from "@/Components/Book.vue";

const modalIsOpen = ref(false);
const deleteModalIsOpen = ref(false);
const selectedBook = ref({});

defineProps(["books"]);

provide("modalIsOpen", modalIsOpen);

function toggleBookFormModal(value) {
    modalIsOpen.value = value;
    if (!value) {
        selectedBook.value = {};
    }
}

function openEditModal(book) {
    selectedBook.value = book;
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
        <div class="sticky top-16">
            <div class="flex w-full bg-gray-100 justify-end px-7 py-3 mt-7">
                <PrimaryButton
                    v-if="$page.props.auth.user.isAdmin"
                    @click="toggleBookFormModal(true)"
                    >Add Book</PrimaryButton
                >
            </div>
        </div>
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            <Book
                v-for="book in books"
                :key="book.id"
                :book="book"
                @edit="openEditModal"
                @delete="openDeleteModal"
            />
        </div>
        <!-- 
        <ModalContainer @close-modal="toggleBookFormModal(false)">
            <span class="bg-dark w-full">hi</span>
            <BookForm />
        </ModalContainer>
								 -->

        <ModalContainer
            id="delete-form-modal"
            :show="deleteModalIsOpen"
            @close="() => (deleteModalIsOpen = false)"
        >
            <div>
                <p>Delete {{ selectedBook.name }}</p>
            </div>
        </ModalContainer>

        <ModalContainer
            id="book-form-modal"
            :show="modalIsOpen"
            @close="toggleBookFormModal(false)"
        >
            <!-- <span class="bg-dark w-full">hi</span> -->
            <BookForm :book="selectedBook" />
        </ModalContainer>
    </AuthenticatedLayout>
</template>
