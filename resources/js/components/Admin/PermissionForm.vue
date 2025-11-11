<script setup lang="ts">
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { useForm } from "@inertiajs/vue3";

interface Props {
    onSubmit: (data: { name: string }) => void;
    processing: boolean;
    errors?: Record<string, string>;
}

const props = defineProps<Props>();
const form = useForm({
    name: "",
});

const handleSubmit = () => {
    props.onSubmit(form.data());
    form.reset();
};
</script>

<template>
    <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
            <Label for="name">Name</Label>
            <Input
                id="name"
                v-model="form.name"
                placeholder="Enter name"
                :disabled="processing"
            />
            <div
                v-if="errors?.name"
                class="text-red-500 text-sm mt-1"
            >
                {{ errors.name }}
            </div>
        </div>

        <Button
            type="submit"
            :disabled="processing"
            class="w-full md:w-auto"
        >
            <span v-if="!processing">Submit</span>
            <span v-else>Submitting...</span>
        </Button>
    </form>
</template>