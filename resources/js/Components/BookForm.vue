<script setup>
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import InputField from "./InputField.vue";

const form = useForm({
    name: "",
    publisher: "",
    isbn: "",
    pages: null, // Adjust to the appropriate data type for 'pages'
    category: "",
    subCategory: "",
    description: "",
});
</script>

<template>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form class="flex flex-col gap-2">
            <div class="grid grid-cols-2 gap-2">
                <InputField
                    id="bookName"
                    label="Name"
                    placeholder="Book Name/Title"
                    v-model="form.name"
                />
                <InputField
                    id="publisher"
                    label="Publisher"
                    v-model="form.publisher"
                    placeholder="Book Publisher"
                />
            </div>

            <div class="grid grid-cols-2 gap-2">
                <InputField
                    id="isbn"
                    label="ISBN"
                    v-model="form.isbn"
                    placeholder="Book Serial Number/ Bar Code Number"
                />
                <InputField
                    type="number"
                    label="Number of Pages"
                    id="pages"
                    v-model="form.pages"
                    placeholder="Number of Pages"
                />
            </div>

            <div class="grid grid-cols-2 gap-2">
                <InputField
                    id="category"
                    label="Category"
                    v-model="form.category"
                    placeholder="Category"
                />

                <InputField
                    id="subCategory"
                    label="Sub Category"
                    v-model="form.subCategory"
                    placeholder="Sub Category"
                />
            </div>

            <label for="description">
                Description
                <textarea
                    id="description"
                    v-model="form.description"
                    placeholder="Enter Book Description"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
            </label>

            <PrimaryButton
                class="flex flex-col w-full mt-2 !bg-transparent ring-1 ring-gray-800 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
                <label
                    htmlFor="product-images-upload"
                    class="z-0 absolute pt-0.5 text-black"
                    >Add Images</label
                >
                <input
                    type="file"
                    id="product-images-upload"
                    class="opacity-0 z-10"
                />
            </PrimaryButton>

            <InputError :message="form.errors.message" class="mt-2" />
            <PrimaryButton class="mt-4 justify-center !py-3.5"
                >Add Book</PrimaryButton
            >
        </form>
    </div>
</template>
