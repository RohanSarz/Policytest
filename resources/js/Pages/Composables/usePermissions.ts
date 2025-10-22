// composables/usePermissions.ts
import { usePage } from "@inertiajs/vue3";

export function useCan() {
    const { permissions } = usePage().props.auth;
    return (permission: string) => permissions?.includes(permission) || false;
}
