<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BookForm from "@/Components/BookForm.vue";
import ModalContainer from "@/Components/ModalContainer.vue";

import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Books" />

    <AuthenticatedLayout>
        <ModalContainer>
            <!-- <span class="bg-dark w-full">hi</span> -->
            <BookForm />
        </ModalContainer>
    </AuthenticatedLayout>
</template>
