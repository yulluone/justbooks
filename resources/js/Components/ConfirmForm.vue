<script setup>
import PrimaryButton from "./PrimaryButton.vue";

const props = defineProps(["message"]);

const emit = defineEmits(["confirmed", "rejected"]);
</script>

<template>
    <div
        class="bg-white shadow-md p-6 flex flex-col gap-4 border border-red-500"
    >
        <span class=""> {{ message }} </span>

        <div class="flex gap-4">
            <PrimaryButton class="!bg-blue-500" @click="emit('rejected')">
                No
            </PrimaryButton>
            <PrimaryButton class="!bg-red-500" @click="emit('confirmed')">
                Yes
            </PrimaryButton>
        </div>
    </div>
</template>
