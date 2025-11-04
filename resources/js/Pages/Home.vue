<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";

let can = usePage().props.auth.can;

// Breaking News Ticker data
const breakingNews = ref([
    "BREAKING: Major policy changes announced in tonight's speech",
    "URGENT: Weather alert issued for coastal regions",
    "LATEST: New discovery in space exploration震撼 science community",
    "UPDATE: Economic indicators show positive growth trends",
]);

// Comments data
const comments = ref([
    {
        id: 1,
        author: "John Smith",
        content: "Great article! I really appreciate the detailed analysis.",
        date: "Nov 4, 2025",
    },
    {
        id: 2,
        author: "Sarah Johnson",
        content: "This is a very important issue that needs more attention.",
        date: "Nov 4, 2025",
    },
    {
        id: 3,
        author: "Mike Davis",
        content:
            "Thanks for covering this topic. Looking forward to more updates.",
        date: "Nov 4, 2025",
    },
]);

// Related articles data
const relatedArticles = ref([
    { id: 1, title: "How Technology is Changing Journalism", category: "Tech" },
    {
        id: 2,
        title: "Environmental Impact of Modern Industry",
        category: "Environment",
    },
    {
        id: 3,
        title: "Local Business Spotlight: Success Stories",
        category: "Business",
    },
    { id: 4, title: "Cultural Events This Weekend", category: "Culture" },
]);

// Social media posts data
const socialPosts = ref([
    {
        id: 1,
        platform: "Twitter",
        content:
            "Our latest article on climate change has important implications for policy makers. #ClimateAction",
        date: "2 hours ago",
    },
    {
        id: 2,
        platform: "Facebook",
        content:
            "Meet the team behind our award-winning investigative journalism. Learn about their process and dedication to truth.",
        date: "4 hours ago",
    },
]);

// Author bio data
const authorBio = {
    name: "Jane Reporter",
    bio: "Jane Reporter is an award-winning journalist with over 15 years of experience covering international affairs and environmental issues. She has reported from over 40 countries and is passionate about telling stories that make a difference.",
    image: "https://placehold.co/100x100",
    social: {
        twitter: "@janereporter",
        linkedin: "Jane Reporter",
    },
};

// Live updates data
const liveUpdates = ref([
    {
        id: 1,
        time: "10:45 AM",
        content:
            "Additional details about the policy changes announced yesterday have been released by the Ministry of Finance.",
    },
    {
        id: 2,
        time: "11:30 AM",
        content:
            "The weather alert has been downgraded from severe to moderate, with conditions expected to improve by evening.",
    },
]);

// Search function
const performSearch = (query) => {
    alert(`Searching for: ${query}`);
};
</script>

<template>
    <div class="bg-white text-black antialiased min-h-screen font-serif">
        <!-- Breaking News Ticker -->
        <div
            data-aos="slide-down"
            class="bg-black text-white py-2 overflow-hidden"
        >
            <div class="flex text-sm animate-marquee whitespace-nowrap">
                <span
                    class="mx-4"
                    v-for="(news, index) in breakingNews"
                    :key="index"
                >
                    {{ news }} &nbsp; | &nbsp;
                </span>
                <span
                    class="mx-4"
                    v-for="(news, index) in breakingNews"
                    :key="`duplicate-${index}`"
                >
                    {{ news }} &nbsp; | &nbsp;
                </span>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto w-full px-4 py-8">
            <!-- Live Blog/Updates Section -->
            <section
                data-aos="fade-up"
                data-aos-delay="100"
                class="bg-gray-100 p-6 border border-gray-300 mb-8"
            >
                <h2
                    class="text-2xl font-bold text-black mb-4 flex items-center"
                >
                    <span
                        class="bg-black text-white text-xs px-2 py-1 rounded mr-2"
                        >LIVE</span
                    >
                    Breaking Updates
                </h2>
                <div class="space-y-4">
                    <div
                        v-for="update in liveUpdates"
                        :key="update.id"
                        class="border-l-4 border-black pl-4 py-2"
                    >
                        <div class="flex items-center mb-1">
                            <span
                                class="text-xs bg-gray-200 text-black px-2 py-1 rounded mr-3"
                                >{{ update.time }}</span
                            >
                        </div>
                        <p class="text-gray-800">{{ update.content }}</p>
                    </div>
                </div>
            </section>

            <article class="lg:col-span-2 space-y-8">
                <section data-aos="fade-up" data-aos-delay="300">
                    <h2 class="text-2xl font-bold text-black mb-4">
                        Featured Stories
                    </h2>
                    <div class="prose prose-black max-w-none">
                        <article class="mb-8">
                            <h3 class="text-xl font-bold text-black">
                                The Future of Urban Agriculture
                            </h3>
                            <p class="text-sm text-gray-700 italic">
                                By Jane Reporter | November 3
                            </p>
                            <p class="mt-3 leading-relaxed">
                                As cities expand and arable land shrinks,
                                innovative vertical farming techniques are
                                taking root in metropolitan centers worldwide.
                                These controlled environment agriculture systems
                                use significantly less water and pesticides than
                                traditional farming, while producing crops
                                year-round regardless of weather conditions...
                            </p>

                            <!-- Author Bio Box -->
                            <div
                                data-aos="fade-up"
                                data-aos-delay="400"
                                class="mt-8 bg-gray-100 p-5 border border-gray-300 rounded"
                            >
                                <div class="flex items-start">
                                    <img
                                        :src="authorBio.image"
                                        alt="Author"
                                        class="w-16 h-16 rounded-full mr-4"
                                    />
                                    <div>
                                        <h4
                                            class="font-bold text-lg text-black"
                                        >
                                            {{ authorBio.name }}
                                        </h4>
                                        <p class="text-sm mt-1 text-gray-800">
                                            {{ authorBio.bio }}
                                        </p>
                                        <div class="mt-2 flex space-x-4">
                                            <a
                                                :href="`https://twitter.com/${authorBio.social.twitter.replace('@', '')}`"
                                                class="text-blue-600 hover:underline"
                                                >{{
                                                    authorBio.social.twitter
                                                }}</a
                                            >
                                            <a
                                                :href="`https://linkedin.com/in/${authorBio.social.linkedin.replace(' ', '')}`"
                                                class="text-blue-600 hover:underline"
                                                >{{
                                                    authorBio.social.linkedin
                                                }}</a
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Comments Section -->
                            <div
                                data-aos="fade-up"
                                data-aos-delay="500"
                                class="mt-8"
                            >
                                <h4 class="text-xl font-bold text-black mb-4">
                                    Comments ({{ comments.length }})
                                </h4>
                                <div class="space-y-4">
                                    <div
                                        v-for="comment in comments"
                                        :key="comment.id"
                                        class="border-b border-gray-200 pb-4"
                                    >
                                        <div class="flex justify-between">
                                            <h5 class="font-bold text-black">
                                                {{ comment.author }}
                                            </h5>
                                            <span
                                                class="text-sm text-gray-600"
                                                >{{ comment.date }}</span
                                            >
                                        </div>
                                        <p class="mt-2 text-gray-700">
                                            {{ comment.content }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Comment Form -->
                                <div class="mt-6">
                                    <h5 class="font-bold text-black mb-2">
                                        Leave a Comment
                                    </h5>
                                    <textarea
                                        class="w-full p-3 border border-gray-300 rounded text-black"
                                        rows="4"
                                        placeholder="Share your thoughts..."
                                    ></textarea>
                                    <button
                                        class="mt-2 bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-4 rounded"
                                    >
                                        Post Comment
                                    </button>
                                </div>
                            </div>
                        </article>
                    </div>
                </section>
            </article>

            <!-- Related Articles Section -->
            <div data-aos="fade-up" data-aos-delay="700" class="mt-12">
                <h3 class="text-2xl font-bold text-black mb-6">
                    Recommended Reading
                </h3>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                >
                    <div
                        v-for="article in relatedArticles"
                        :key="article.id"
                        class="border border-gray-200 rounded p-4 hover:bg-gray-50 transition-colors"
                    >
                        <span
                            class="text-xs bg-gray-100 text-black px-2 py-1 rounded"
                            >{{ article.category }}</span
                        >
                        <h4 class="font-bold text-black mt-3 mb-2">
                            {{ article.title }}
                        </h4>
                        <a
                            href="#"
                            class="text-gray-700 hover:underline text-sm"
                            >Read more →</a
                        >
                    </div>
                </div>
            </div>

            <!-- Social Media Feeds Section -->
            <section
                data-aos="fade-up"
                data-aos-delay="800"
                class="mt-12 bg-gray-100 p-6 border border-gray-300"
            >
                <h3 class="text-2xl font-bold text-black mb-4">Follow Us</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div
                        v-for="post in socialPosts"
                        :key="post.id"
                        class="bg-white p-4 border border-gray-200 rounded"
                    >
                        <div class="flex items-center mb-3">
                            <span
                                class="font-bold bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs"
                                >{{ post.platform }}</span
                            >
                            <span class="ml-3 text-sm text-gray-600">{{
                                post.date
                            }}</span>
                        </div>
                        <p class="text-gray-800">{{ post.content }}</p>
                        <a
                            href="#"
                            class="mt-3 inline-block text-blue-600 hover:underline text-sm"
                            >View on {{ post.platform }}</a
                        >
                    </div>
                </div>
            </section>

            <!-- Advertisement Section -->
            <section
                data-aos="fade-up"
                data-aos-delay="900"
                class="mt-12 flex justify-center"
            >
                <div
                    class="bg-gradient-to-r from-gray-700 to-black p-8 w-full rounded-lg text-white text-center"
                >
                    <h3 class="text-2xl font-bold mb-2">Advertisement</h3>
                    <p class="mb-4">
                        Your product or service could appear here
                    </p>
                    <button
                        class="bg-white text-black font-bold py-2 px-6 rounded hover:bg-gray-200"
                    >
                        Learn More
                    </button>
                </div>
            </section>

            <section
                data-aos="fade-up"
                data-aos-delay="1100"
                class="bg-gray-100 p-6 border border-gray-300 mt-8"
            >
                <h3 class="text-lg font-bold text-black mb-4">
                    Opinion & Editorial
                </h3>
                <ul class="space-y-3">
                    <li>
                        <a href="#" class="hover:underline text-gray-800"
                            >The Need for Digital Privacy Reform</a
                        >
                    </li>
                    <li>
                        <a href="#" class="hover:underline text-gray-800"
                            >Reflections on Economic Inequality</a
                        >
                    </li>
                    <li>
                        <a href="#" class="hover:underline text-gray-800"
                            >Why Local Journalism Matters</a
                        >
                    </li>
                </ul>
            </section>

            <section
                data-aos="fade-up"
                data-aos-delay="1200"
                class="bg-gray-100 p-6 border border-gray-300 mt-8"
            >
                <h3 class="text-lg font-bold text-black mb-4">
                    Weather & Horoscope
                </h3>
                <p class="text-gray-800">
                    Sunny, 72°F. Clear skies through the weekend.
                </p>
            </section>

            <section
                data-aos="fade-up"
                data-aos-delay="1300"
                class="bg-gray-100 p-6 border border-gray-300 mt-8"
            >
                <h3 class="text-lg font-bold text-black mb-4">Classifieds</h3>
                <ul class="text-sm space-y-2">
                    <li class="border-b border-gray-300 pb-2">
                        Vintage Typewriter for Sale
                    </li>
                    <li class="border-b border-gray-300 pb-2">
                        Tutoring: Math & Science
                    </li>
                    <li>Looking for Roommate</li>
                </ul>
            </section>
        </div>
    </div>
</template>

<!-- Animation for the breaking news ticker -->
<style>
@keyframes marquee {
    0% {
        transform: translateX(50%);
    }
    100% {
        transform: translateX(-100%);
    }
}

.animate-marquee {
    animation: marquee 80s linear infinite;
    display: inline-block;
}
</style>
