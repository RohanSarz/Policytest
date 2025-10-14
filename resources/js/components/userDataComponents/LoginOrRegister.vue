<template>
    <li v-if="!$page.props.auth.user" class="flex-1 text-gray-400">
        Please
        <Link class="hover:underline hover:text-gray-700" href="/login"
            >Login</Link
        >
        or
        <Link class="hover:underline hover:text-gray-700" href="/register">
            Register</Link
        >
        to continue.
    </li>
</template>
