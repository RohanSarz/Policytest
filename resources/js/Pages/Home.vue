<script setup lang="ts">
import PostCard from "@/components/post/PostCard.vue";
import {
    ToastAction,
    ToastClose,
    ToastDescription,
    ToastProvider,
    ToastRoot,
    ToastTitle,
    ToastViewport,
} from "radix-vue";
import { TransitionGroup } from "vue";
interface User {
    id: number;
    name: string;
    avatar: string;
}

interface Post {
    id: number;
    user: User;
    title: string;
    description: string;
    content: string;
    created_at: string;
    updated_at: string;
}

const fakePosts: Post[] = [
    {
        id: 1,
        user: {
            id: 1,
            name: "Jane Smith",
            avatar: "avatars/jane.jpg",
        },
        title: "Breaking: Major Policy Change Announced",
        description:
            "Government announces sweeping new policy changes that will affect millions of citizens nationwide.",
        content:
            "In a surprise move today, the administration announced a comprehensive policy overhaul that will reshape the economic landscape. The changes include new tax regulations, healthcare provisions, and infrastructure investments worth billions of dollars. Experts predict this will have long-term implications for various sectors of the economy.",
        created_at: "2025-10-15T09:30:00Z",
        updated_at: "2025-10-15T09:30:00Z",
    },
    {
        id: 2,
        user: {
            id: 2,
            name: "Michael Johnson",
            avatar: "avatars/michael.jpg",
        },
        title: "Local Heroes Save Community Shelter",
        description:
            "A group of volunteers has stepped up to save the downtown animal shelter from closure.",
        content:
            "The downtown animal shelter was facing potential closure due to funding issues, but a group of local volunteers and donors has come together to ensure its continued operation. The effort has raised over $25,000 in just two weeks, surpassing their initial goal and securing the shelter's operations for the next year.",
        created_at: "2025-10-14T14:20:00Z",
        updated_at: "2025-10-14T14:20:00Z",
    },
    {
        id: 3,
        user: {
            id: 3,
            name: "Sarah Williams",
            avatar: "avatars/sarah.jpg",
        },
        title: "Tech Giant Unveils Revolutionary AI Technology",
        description:
            "In a landmark announcement, the tech company revealed an AI system that promises to change the industry.",
        content:
            "At the annual technology conference, the company demonstrated an artificial intelligence system capable of understanding and responding to complex human emotions. Industry experts are calling this breakthrough a potential game-changer that could revolutionize how humans interact with technology in various fields including healthcare, education, and customer service.",
        created_at: "2025-10-13T11:45:00Z",
        updated_at: "2025-10-13T11:45:00Z",
    },
    {
        id: 4,
        user: {
            id: 4,
            name: "David Chen",
            avatar: "avatars/david.jpg",
        },
        title: "New Study Shows Benefits of Mediterranean Diet",
        description:
            "Research confirms significant health improvements associated with traditional Mediterranean eating patterns.",
        content:
            "A comprehensive 10-year study involving over 50,000 participants has found that adhering to a Mediterranean diet can reduce the risk of heart disease by up to 30%. The research, published in the New England Journal of Medicine, details how this traditional eating pattern rich in olive oil, fish, and vegetables provides cardiovascular benefits beyond what was previously understood.",
        created_at: "2025-10-12T16:10:00Z",
        updated_at: "2025-10-12T16:10:00Z",
    },
    {
        id: 5,
        user: {
            id: 5,
            name: "Emma Rodriguez",
            avatar: "avatars/emma.jpg",
        },
        title: "City Council Approves New Housing Initiative",
        description:
            "Plan aims to address the growing housing affordability crisis in urban areas.",
        content:
            "The city council voted unanimously to approve a new affordable housing initiative that will create 500 new units over the next three years. The plan includes provisions for first-time homebuyer assistance and rent stabilization measures. Officials hope this will help address the ongoing housing affordability crisis that has affected thousands of residents.",
        created_at: "2025-10-11T10:30:00Z",
        updated_at: "2025-10-11T10:30:00Z",
    },
    {
        id: 6,
        user: {
            id: 6,
            name: "Robert Kim",
            avatar: "avatars/robert.jpg",
        },
        title: "Climate Summit Results Exceed Expectations",
        description:
            "International leaders agree on ambitious new targets to combat climate change.",
        content:
            "The international climate summit concluded with countries committing to more aggressive carbon reduction goals than previously anticipated. The agreement includes provisions for funding climate technology in developing nations and establishing new emissions monitoring systems. Scientists say the commitments could help limit global warming to below 1.5 degrees Celsius.",
        created_at: "2025-10-10T13:15:00Z",
        updated_at: "2025-10-10T13:15:00Z",
    },
    {
        id: 7,
        user: {
            id: 7,
            name: "Olivia Parker",
            avatar: "avatars/olivia.jpg",
        },
        title: "Renewable Energy Sector Shows Record Growth",
        description:
            "Solar and wind power installations reach new highs worldwide.",
        content:
            "The renewable energy sector has experienced unprecedented growth, with solar and wind installations reaching record levels globally. Industry analysts report a 23% increase in renewable capacity compared to last year, marking the strongest growth period in the sector's history. The trend is expected to continue as costs for renewable technologies continue to decline.",
        created_at: "2025-10-09T08:45:00Z",
        updated_at: "2025-10-09T08:45:00Z",
    },
    {
        id: 8,
        user: {
            id: 8,
            name: "James Wilson",
            avatar: "avatars/james.jpg",
        },
        title: "New Educational Program Launched for Underserved Communities",
        description:
            "Initiative aims to bridge the digital divide with technology training.",
        content:
            "A new educational initiative has been launched to provide technology training and resources to underserved communities. The program will offer free computer literacy classes, internet access, and career development resources to over 10,000 residents in affected areas. Organizers expect this to help participants access better employment opportunities and educational resources.",
        created_at: "2025-10-08T15:20:00Z",
        updated_at: "2025-10-08T15:20:00Z",
    },
    {
        id: 9,
        user: {
            id: 9,
            name: "Amanda Taylor",
            avatar: "avatars/amanda.jpg",
        },
        title: "Historic Downtown Building to Be Preserved",
        description:
            "Landmark structure will be converted into cultural center.",
        content:
            "After years of debate, city officials have reached an agreement to preserve the historic downtown building and convert it into a community cultural center. The project will maintain the architectural integrity of the 1920s building while adapting it for modern use as an exhibition space, performance venue, and educational center for local artists.",
        created_at: "2025-10-07T12:30:00Z",
        updated_at: "2025-10-07T12:30:00Z",
    },
    {
        id: 10,
        user: {
            id: 10,
            name: "Christopher Lee",
            avatar: "avatars/christopher.jpg",
        },
        title: "Medical Breakthrough Offers Hope for Rare Disease",
        description:
            "New treatment shows promising results in clinical trials.",
        content:
            "Researchers have announced promising results from clinical trials of a new treatment for a rare genetic disorder that affects thousands worldwide. The therapy targets the root cause of the condition rather than just managing symptoms. If approved, it could offer a significant improvement in quality of life for patients and their families who have been waiting for such a treatment.",
        created_at: "2025-10-06T09:15:00Z",
        updated_at: "2025-10-06T09:15:00Z",
    },
    {
        id: 11,
        user: {
            id: 11,
            name: "Sophia Martinez",
            avatar: "avatars/sophia.jpg",
        },
        title: "Local Farm Wins National Sustainability Award",
        description:
            "Innovative farming techniques earn recognition for environmental stewardship.",
        content:
            "A local family farm has been recognized nationally for its innovative sustainable farming practices that have improved soil health while increasing crop yields. The farm's approach includes crop rotation, natural pest management, and water conservation techniques that other farms are now looking to adopt. The award highlights the importance of sustainable agriculture in addressing environmental challenges.",
        created_at: "2025-10-05T16:40:00Z",
        updated_at: "2025-10-05T16:40:00Z",
    },
    {
        id: 12,
        user: {
            id: 12,
            name: "Ryan Thompson",
            avatar: "avatars/ryan.jpg",
        },
        title: "Transportation Authority Announces New Bus Routes",
        description:
            "Expansion will improve access to underserved neighborhoods.",
        content:
            "The city's transportation authority has announced the launch of three new bus routes designed to improve public transit access in previously underserved neighborhoods. The expansion will connect these areas to downtown, major shopping centers, and healthcare facilities. City planners expect the improved access will benefit over 15,000 residents daily.",
        created_at: "2025-10-04T11:05:00Z",
        updated_at: "2025-10-04T11:05:00Z",
    },
    {
        id: 13,
        user: {
            id: 13,
            name: "Isabella Garcia",
            avatar: "avatars/isabella.jpg",
        },
        title: "Arts Festival Draws Record Crowds",
        description:
            "Annual celebration of local artists and performers exceeds expectations.",
        content:
            "This year's annual arts festival drew the largest crowd in its 20-year history, with over 50,000 visitors attending over the weekend. The festival featured more than 200 local artists, musicians, and performers across multiple venues. Organizers reported increased vendor sales and announced plans to expand next year's event based on the overwhelming response.",
        created_at: "2025-10-03T14:25:00Z",
        updated_at: "2025-10-03T14:25:00Z",
    },
];
</script>

<template>
    <Head :title="$page.component" />

    <div class="grid grid-cols-2 place-items-center space-y-4 py-4">
        <!-- TransitionGroup directly wraps the PostCard list -->

        <PostCard
            v-for="post in fakePosts"
            :key="post.id"
            :post="post"
            class="post-item"
            data-aos="zoom-in-up"
            data-aos-duration="500"
        />
    </div>
</template>
