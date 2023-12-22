<script setup>
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import InputField from "./InputField.vue";
import { ref } from "vue";

const form = useForm({
    name: "",
    publisher: "",
    isbn: "",
    pages: 1,
    category: "",
    sub_category: "",
    description: "",
    image: null,
});

const success = ref(false);
const loading = ref(false);

const handleImage = async (event) => {
    form.image = event.target.files[0];
};
</script>

<template>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form
            class="flex flex-col gap-2"
            @submit.prevent="
                form.post(route('books.store'), {
                    onProgress: () => (loading = true),
                    onSuccess: () => {
                        form.reset(), (success = true), (loading = false);
                    },
                })
            "
        >
            <div class="grid grid-cols-2 gap-2">
                <div>
                    <InputField
                        id="bookName"
                        label="Name"
                        placeholder="Book Name/Title"
                        v-model="form.name"
                        :value="form.name"
                        required
                    />
                    <InputError :message="form.errors.name" class="mt-2" />
                </div>
                <div>
                    <InputField
                        id="publisher"
                        label="Publisher"
                        v-model="form.publisher"
                        placeholder="Book Publisher"
                        :value="form.publisher"
                    />
                    <InputError :message="form.errors.publisher" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <InputField
                        id="isbn"
                        label="ISBN"
                        v-model="form.isbn"
                        placeholder="Book Serial Number/ Bar Code Number"
                        :value="form.isbn"
                    />

                    <InputError :message="form.errors.isbn" class="mt-2" />
                </div>

                <div>
                    <InputField
                        type="number"
                        label="Number of Pages"
                        id="pages"
                        v-model="form.pages"
                        placeholder="Number of Pages"
                        :value="form.pages"
                    />

                    <InputError :message="form.errors.pages" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <div>
                    <InputField
                        id="category"
                        label="Category"
                        v-model="form.category"
                        placeholder="Eg. Fiction"
                        :value="form.category"
                    />

                    <InputError :message="form.errors.category" class="mt-2" />
                </div>

                <div>
                    <InputField
                        id="subCategory"
                        label="Sub Category"
                        v-model="form.sub_category"
                        :value="form.sub_category"
                        placeholder="Eg. Science Fiction"
                    />

                    <InputError
                        :message="form.errors.sub_category"
                        class="mt-2"
                    />
                </div>
            </div>

            <label for="description">
                Description
                <textarea
                    id="description"
                    v-model="form.description"
                    placeholder="Book Synopsis"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>

                <InputError :message="form.errors.description" class="mt-2" />
            </label>

            <PrimaryButton
                class="flex flex-col w-full mt-2 !bg-transparent !p-0 ring-1 ring-gray-800 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
                <label
                    htmlFor="product-images-upload"
                    class="z-0 absolute pt-0.5 text-black flex items-center justify-center h-10 w-[50vw] xs:w-[70vw] overflow-hidden"
                >
                    <span v-if="form.image" class="w-full">
                        {{ form.image.name }}
                    </span>
                    <span v-else> Add Image </span>
                </label>
                <input
                    type="file"
                    accept="image/*"
                    id="product-images-upload"
                    class="opacity-0 z-10 w-full h-10"
                    @change="handleImage"
                />
            </PrimaryButton>

            <PrimaryButton
                type="submit"
                :disabled="
                    !form.name ||
                    !form.isbn ||
                    !form.category ||
                    !form.sub_category ||
                    !form.publisher ||
                    !form.description ||
                    !form.image
                "
                class="mt-4 justify-center !py-3.5"
                >{{
                    loading ? "Adding..." : success ? " Book Added" : "Add Book"
                }}</PrimaryButton
            >
        </form>
    </div>
</template>
