<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: "text",
    },
    label: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        default: "",
    },
    value: {
        type: [String, Number],
        default: "",
    },
});

const emits = defineEmits(["input"]);

const updateValue = (event) => {
    emits("input", event.target.value);
};
</script>

<template>
    <label :for="id">
        {{ label }}
        <input
            :id="id"
            :type="type"
            :placeholder="placeholder"
            :value="value"
            @input="$emit('input', $event.target.value)"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        />
    </label>
</template>
