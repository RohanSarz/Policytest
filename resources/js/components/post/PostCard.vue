<script setup>
import { Link } from "@inertiajs/vue3";
import {
    Card,
    CardHeader,
    CardTitle,
    CardContent,
    CardFooter,
} from "@/components/ui/card";
import { Avatar, AvatarImage, AvatarFallback } from "@/components/ui/avatar";

// ✅ Correct way to define props in <script setup>
const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
});

// You can also destructure if you prefer:
// const { post } = defineProps({ post: Object })
</script>

<template>
    <!-- Use props.post since we didn’t destructure -->
    <Card
        v-if="props.post"
        class="min-w-[280px] sm:min-w-[320px] max-w-lg w-full"
    >
        <CardHeader class="pb-3">
            <div v-if="props.post.user" class="flex items-center gap-4">
                <Link :href="`/users/${props.post.user.id}`">
                    <Avatar class="ring-1">
                        <AvatarImage
                            :src="
                                props.post.user.avatar
                                    ? `/storage/${props.post.user.avatar}`
                                    : '/storage/avatars/def.jpg'
                            "
                            :alt="props.post.user.name"
                            @error="
                                $event.target.src = '/storage/avatars/def.jpg'
                            "
                        />
                        <AvatarFallback>
                            {{ props.post.user.name?.charAt(0).toUpperCase() }}
                        </AvatarFallback>
                    </Avatar>
                </Link>
                <div class="min-w-0 flex-1">
                    <Link
                        :href="`/users/${props.post.user.id}`"
                        class="hover:underline"
                    >
                        <h4 class="text-sm font-semibold truncate">
                            {{ props.post.user.name }}
                        </h4>
                    </Link>
                    <p class="text-xs text-muted-foreground">
                        {{
                            new Date(props.post.created_at).toLocaleDateString()
                        }}
                    </p>
                </div>
            </div>

            <div v-else class="flex items-center gap-4">
                <Avatar class="ring-1">
                    <AvatarImage
                        src="/storage/avatars/def.jpg"
                        alt="Loading..."
                    />
                    <AvatarFallback>U</AvatarFallback>
                </Avatar>
                <div class="min-w-0 flex-1">
                    <h4 class="text-sm font-semibold truncate">Loading...</h4>
                    <p class="text-xs text-muted-foreground">Loading...</p>
                </div>
            </div>

            <CardTitle class="text-xl mt-2">
                {{ props.post.title || "Loading..." }}
            </CardTitle>
        </CardHeader>

        <CardContent class="pb-3">
            <p
                class="text-sm text-muted-foreground whitespace-pre-wrap break-words overflow-hidden line-clamp-6"
            >
                {{ props.post.body || "Loading post content..." }}
            </p>
        </CardContent>

        <CardFooter>
            <Link
                :href="`/posts/${props.post.slug}`"
                class="text-sm font-medium hover:underline"
            >
                Read more
            </Link>
        </CardFooter>
    </Card>
</template>
