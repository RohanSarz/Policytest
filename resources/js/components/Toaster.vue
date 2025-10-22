<script setup>
import { ref, watch, nextTick, computed } from "vue";
import { usePage } from "@inertiajs/vue3";

// Lucide icons (lightweight, only import what you use)
import {
    Info,
    CheckCircle,
    AlertTriangle,
    XCircle,
    Bell,
} from "lucide-vue-next";

const page = usePage();
const isVisible = ref(false);
let hideTimeout = null;

// Flash data (assume shape: { message: string, type?: string })
const flash = computed(() => page.props.flash || {});
const message = computed(() => flash.value.message || "");
const type = computed(() => flash.value.type || "default");

// Map type to icon component
const iconMap = {
    info: Info,
    success: CheckCircle,
    warning: AlertTriangle,
    error: XCircle,
    default: Bell,
    neutral: Bell,
};

const iconComponent = computed(() => iconMap[type.value] || Bell);

// Map type to Tailwind color classes
const colorClasses = computed(() => {
    const colors = {
        neutral:
            "text-gray-500 bg-gray-100 dark:bg-gray-700 dark:text-gray-200",
        default:
            "text-gray-500 bg-gray-100 dark:bg-gray-700 dark:text-gray-200",
        success:
            "text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200",
        error: "text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200",
        warning:
            "text-yellow-500 bg-yellow-100 dark:bg-yellow-800 dark:text-yellow-200",
        info: "text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200",
    };
    return colors[type.value] || colors.default;
});

// Track the last flash data to detect changes
const lastFlashData = ref({});

// Watch for changes in flash data (any property change)
watch(
    () => page.props.flash,
    async (newFlash) => {
        // Check if the flash data has actually changed
        const currentFlash = newFlash || {};
        if (JSON.stringify(currentFlash) !== JSON.stringify(lastFlashData.value)) {
            lastFlashData.value = { ...currentFlash };
            
            if (!currentFlash.message) {
                isVisible.value = false;
                return;
            }

            clearTimeout(hideTimeout);
            isVisible.value = false;
            await nextTick();
            isVisible.value = true;

            hideTimeout = setTimeout(() => {
                isVisible.value = false;
            }, 5000);
        }
    },
    { immediate: true, deep: true }
);

function closeToast() {
    isVisible.value = false;
    clearTimeout(hideTimeout);
}
</script>

<template>
    <Transition
        enter-from-class="opacity-0 translate-y-2"
        enter-to-class="opacity-100 translate-y-0"
        enter-active-class="transition ease-out duration-300"
        leave-from-class="opacity-100 translate-y-0"
        leave-to-class="opacity-0 translate-y-2"
        leave-active-class="transition ease-in duration-300"
    >
        <div
            v-if="isVisible && message"
            id="toast-default"
            class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800"
            role="alert"
        >
            <!-- Icon container -->
            <div
                class="inline-flex items-center justify-center shrink-0 w-8 h-8 rounded-lg"
                :class="colorClasses"
            >
                <component
                    :is="iconComponent"
                    class="w-4 h-4"
                    aria-hidden="true"
                />
                <span class="sr-only">{{ type }} icon</span>
            </div>

            <!-- Message -->
            <div class="ms-3 text-sm font-normal">
                {{ message }}
            </div>

            <!-- Close button -->
            <button
                type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                @click="closeToast"
                aria-label="Close"
            >
                <span class="sr-only">Close</span>
                <svg
                    class="w-3 h-3"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 14 14"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                    />
                </svg>
            </button>
        </div>
    </Transition>
</template>
