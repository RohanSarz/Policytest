<template>
    <div v-if="$page.props.flash.message">
        <p
            class="text-sm bg-green-300 rounded-2xl p-2 fixed top-20 right-5 opacity-80 cursor-pointer"
        >
            {{ $page.props.flash.message }}
        </p>
    </div>
    <div v-else>
        <p>{{ $page.errors }}</p>
    </div>
</template>
