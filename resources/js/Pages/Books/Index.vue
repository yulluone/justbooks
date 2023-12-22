<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BookForm from "@/Components/BookForm.vue";
import ModalContainer from "@/Components/ModalContainer.vue";

import { Head } from "@inertiajs/vue3";

import { ref } from "vue";
import { provide } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const modalIsOpen = ref(false);

provide("modalIsOpen", modalIsOpen);

function setModalIsOpen(value) {
    modalIsOpen.value = value;
}
</script>

<template>
    <Head title="Books" />
    <AuthenticatedLayout>
        <div class="flex w-full justify-end px-7 mt-7">
            <PrimaryButton
                v-if="$page.props.auth.user.isAdmin"
                @click="setModalIsOpen(true)"
                >Add Book</PrimaryButton
            >
        </div>
        <ModalContainer @close-modal="setModalIsOpen(false)">
            <!-- <span class="bg-dark w-full">hi</span> -->
            <BookForm />
        </ModalContainer>
    </AuthenticatedLayout>
</template>
