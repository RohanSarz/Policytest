<script setup lang="ts">
interface Permission {
    id: number;
    name: string;
    guard_name: string;
    created_at: string;
    updated_at: string;
}

interface Props {
    permission: Permission;
}

const props = defineProps<Props>();
</script>

<template>
    <div class="border p-4 rounded-lg">
        <div class="flex justify-between items-center">
            <span class="font-medium">{{ permission.name }}</span>
            <span class="text-xs text-gray-500">
                {{ new Date(permission.created_at).toLocaleDateString() }}
            </span>
        </div>
    </div>
</template>