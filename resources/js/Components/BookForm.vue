<script setup>
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import InputField from "./InputField.vue";
import { ref, watchEffect, onUnmounted } from "vue";
import { watch } from "vue";
import { onMounted } from "vue";

const props = defineProps(["book", "editing"]);

const form = useForm({
    name: props.book.name,
    publisher: props.book.publisher,
    isbn: props.book.isbn,
    pages: props.book.pages,
    category: props.book.category,
    sub_category: props.book.sub_category,
    description: props.book.description,
    image: props.book.image,
});

const success = ref(false);
const loading = ref(false);
const canSubmit = ref(false);

const handleImage = async (event) => {
    form.image = event.target.files[0];
};

const handleSubmit = async () => {
    const resourceRoute = props.editing ? "books.update" : "books.store";
    const params = props.editing && props.book.id;
    try {
        props.editing
            ? await form.put(route(resourceRoute, params), {
                  onProgress: () => (loading = true),
                  onSuccess: () => {
                      form.reset(), (success = true), (loading = false);
                  },
              })
            : await form.post(route(resourceRoute, params), {
                  onProgress: () => (loading = true),
                  onSuccess: () => {
                      form.reset(), (success = true), (loading = false);
                  },
              });
    } catch (error) {
        throw error;
    }
};

const addImageButton = ref(null);
const addImageLabel = ref(null);
const labelWidth = ref(0);

const changeWidth = () => {
    if (addImageButton.value) {
        labelWidth.value = addImageButton.value.clientWidth;
    }
};

onMounted(() => {
    labelWidth.value = addImageButton.value.clientWidth;
});

// Watch for changes in clientWidth using watchEffect
watchEffect(() => {
    window.addEventListener("resize", changeWidth); // Optional: Watch for window resize
});

// Clean up event listener on component unmount
onUnmounted(() => {
    window.removeEventListener("resize", changeWidth);
});
</script>

<template>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8 bg-white rounded">
        <form class="flex flex-col gap-5" @submit.prevent="handleSubmit">
            <div class="grid grid-cols-2 gap-5">
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

            <div class="grid grid-cols-2 gap-5">
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

            <div class="grid grid-cols-2 gap-5">
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
                    :style="{
                        width: labelWidth ? 0.7 * labelWidth + 'px' : '50vw',
                    }"
                    ref="addImageLabel"
                    htmlFor="product-images-upload"
                    class="z-0 absolute pt-0.5 text-black flex items-center justify-center h-10 overflow-hidden"
                >
                    <span v-if="form.image" class="w-full">
                        {{
                            !editing
                                ? "Replace Image"
                                : form.image.name
                                ? form.image.name
                                : form.image
                        }}
                    </span>
                    <span v-else> Add Image </span>
                </label>
                <input
                    type="file"
                    accept="image/*"
                    id="product-images-upload"
                    class="opacity-0 z-10 w-full h-10"
                    @change="handleImage"
                    ref="addImageButton"
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
                    loading && !editing
                        ? "Adding..."
                        : loading && editing
                        ? "Updating..."
                        : success && !editing
                        ? " Book Added"
                        : success && editing
                        ? "Book Updated"
                        : !success && editing
                        ? "Save Changes"
                        : "Add Book"
                }}</PrimaryButton
            >
        </form>
    </div>
</template>
