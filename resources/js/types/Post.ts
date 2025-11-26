export interface Post {
    id: number;
    title: string;
    content: string;
    excerpt: string;
    cover_image?: string;
    slug: string;
    created_at: string;
    created_for_human: string;
    updated_at: string;
    status: string;
    user: User;
    category: Category;
    postImages: PostImage[];
}

export interface User {
    id: number;
    name: string;
    email: string;
}

export interface Category {
    id: number;
    name: string;
    slug: string;
}

export interface PostImage {
    id: number;
    url: string;
    order: number;
    alt_text: string | null;
}
