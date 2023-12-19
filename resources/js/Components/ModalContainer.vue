<script setup>
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogOverlay,
} from "@headlessui/vue";
import XMark from "./Icons/XMark.vue";
import { inject } from "vue";

const isOpen = inject("modalIsOpen");

const emit = defineEmits(["close-modal"]);
</script>

<template>
    <TransitionRoot :show="isOpen" as="template">
        <Dialog
            :open="isOpen"
            class="fixed inset-0 z-50 overflow-y-auto overflow-x-hidden xs:p-4"
        >
            <div class="min-h-screen text-center">
                <TransitionChild
                    enter="ease-out duration-300"
                    enter-from="opacity-0"
                    enter-to="opacity-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                >
                    <DialogOverlay
                        class="fixed inset-0 z-40 cursor-pointer bg-dark bg-opacity-60 backdrop-blur dark:bg-opacity-80"
                    />
                </TransitionChild>
                <!-- {/* This element is to trick the browser into centering the
                modal contents. */} -->
                <span class="inline-block align-middle" aria-hidden="true">
                    &#8203;
                </span>

                <TransitionChild
                    enter="ease-out duration-300"
                    enter-from="opacity-0 scale-110"
                    enter-to="opacity-100 scale-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-110"
                >
                    <div
                        class="p-4 xs:p-0 relative z-50 inline-block min-h-screen w-full transform overflow-hidden text-start align-middle transition-all xs:min-h-[auto] xs:w-auto"
                    >
                        <div
                            class="relative flex min-h-screen items-center overflow-hidden xs:block xs:min-h-[auto] rounded-md"
                        >
                            <button
                                @click="emit('close-modal')"
                                aria-label="Close panel"
                                class="absolute top-5 z-10 text-dark-900 outline-none transition-all hover:text-dark focus-visible:outline-none right-4 dark:text-dark-800 hover:dark:text-light-200 md:top-6 md:right-5 lg:top-7 lg:right-7"
                            >
                                <XMark
                                    class="h-4 w-4 focus-visible:outline-none lg:h-[18px] lg:w-[18px] 3xl:h-5 3xl:w-5"
                                />
                            </button>
                            <div class="h-full w-full">
                                <slot />
                            </div>
                        </div>
                    </div>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
