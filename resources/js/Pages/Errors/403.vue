<script setup></script>

<template>
    <Head title="Access Denied" />
    <div class="flex items-center justify-center min-h-screen bg-gray-50">
        <div class="text-center p-6 max-w-md mx-auto">
            <h1 class="text-4xl font-bold text-gray-800">403</h1>
            <h2 class="mt-2 text-xl font-semibold text-gray-700">
                Access Denied
            </h2>
            <p class="mt-3 text-gray-600">
                You don't have permission to access this resource.
            </p>
            <Link
                href="/"
                class="mt-5 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
            >
                Go Home
            </Link>
        </div>
    </div>
</template>
