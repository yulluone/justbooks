<script setup>
const props = defineProps([
    "modelValue",
    "id",
    "type",
    "label",
    "placeholder",
    "class",
]);
const emits = defineEmits(["update:modelValue"]);
</script>

<template>
    <label :for="id" :class="class">
        <span class="ml-3">
            {{ label }}
        </span>
        <input
            :id="id"
            :type="type"
            :placeholder="placeholder"
            :value="modelValue"
            @input="emits('update:modelValue', $event.target.value)"
            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        />
    </label>
</template>
