<template>
    <div class="w-full">
        <div class="border rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                #
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Name
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Email
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Role
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Joined
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="user in fakeUsers" :key="user.id">
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                            >
                                {{ user.id }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                            >
                                {{ user.name }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                            >
                                {{ user.email }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                            >
                                {{ user.role }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    :class="[
                                        'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                        user.status === 'Active'
                                            ? 'bg-green-100 text-green-800'
                                            : 'bg-red-100 text-red-800',
                                    ]"
                                >
                                    {{ user.status }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"
                            >
                                {{ user.joined }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
// Fake user data
const fakeUsers = [
    {
        id: 1,
        name: "John Doe",
        email: "john@example.com",
        role: "Admin",
        status: "Active",
        joined: "2023-01-15",
    },
    {
        id: 2,
        name: "Jane Smith",
        email: "jane@example.com",
        role: "Editor",
        status: "Active",
        joined: "2023-02-20",
    },
    {
        id: 3,
        name: "Robert Johnson",
        email: "robert@example.com",
        role: "User",
        status: "Inactive",
        joined: "2023-03-10",
    },
    {
        id: 4,
        name: "Emily Davis",
        email: "emily@example.com",
        role: "Editor",
        status: "Active",
        joined: "2023-04-05",
    },
    {
        id: 5,
        name: "Michael Wilson",
        email: "michael@example.com",
        role: "User",
        status: "Active",
        joined: "2023-05-12",
    },
    {
        id: 6,
        name: "Sarah Brown",
        email: "sarah@example.com",
        role: "Admin",
        status: "Inactive",
        joined: "2023-06-18",
    },
    {
        id: 7,
        name: "David Taylor",
        email: "david@example.com",
        role: "User",
        status: "Active",
        joined: "2023-07-22",
    },
    {
        id: 8,
        name: "Lisa Anderson",
        email: "lisa@example.com",
        role: "Editor",
        status: "Active",
        joined: "2023-08-30",
    },
];
</script>
