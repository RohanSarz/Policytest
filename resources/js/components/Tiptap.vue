<script setup>
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import Underline from "@tiptap/extension-underline";
import TextAlign from "@tiptap/extension-text-align";
import Strike from "@tiptap/extension-strike";
import Heading from "@tiptap/extension-heading";
import ListItem from "@tiptap/extension-list-item";
import BulletList from "@tiptap/extension-bullet-list";
import OrderedList from "@tiptap/extension-ordered-list";
import { Image } from "@tiptap/extension-image";
import { ref, onMounted, onUnmounted, watch } from "vue";

const props = defineProps({
    modelValue: {
        type: String,
        default: "",
    },
});

const emit = defineEmits(["update:modelValue"]);

const imageInput = ref(null);
const currentImageAlignment = ref("");
const imageSelected = ref(false);

// Update image selection status - define this function first to avoid reference errors
const updateImageSelection = () => {
    if (!editor.value) return;

    const { from } = editor.value.state.selection;
    const node = editor.value.view.state.doc.nodeAt(from);

    if (node && node.type.name === "image") {
        imageSelected.value = true;
        // Get current image alignment
        const attrs = editor.value.getAttributes("image");
        currentImageAlignment.value = attrs.align || "center"; // default to center
    } else {
        imageSelected.value = false;
        currentImageAlignment.value = "";
    }
};

// Define a custom image extension with alignment support
const CustomImage = Image.extend({
    addAttributes() {
        return {
            ...this.parent?.(),
            align: {
                default: "center",
                renderHTML: (attributes) => {
                    return {
                        "data-align": attributes.align,
                        class: `inline-image align-${attributes.align}`,
                    };
                },
                parseHTML: (element) => {
                    return element.getAttribute("data-align") || "center";
                },
            },
        };
    },

    addCommands() {
        return {
            ...this.parent?.(),
            setImageAlignment:
                (alignment) =>
                ({ commands }) => {
                    return commands.updateAttributes("image", {
                        align: alignment,
                    });
                },
        };
    },
});

// Handle image upload
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        // Create a temporary URL for the image
        const reader = new FileReader();
        reader.onload = (e) => {
            // Insert the image into the editor
            editor.value.commands.setImage({ src: e.target.result });
        };
        reader.readAsDataURL(file);

        // Reset the file input
        event.target.value = "";
    }
};

// Function to trigger image selection
const addImage = () => {
    imageInput.value?.click();
};

// Determine the content format and return appropriately
const initialContent = () => {
    const value = props.modelValue;
    
    if (typeof value === 'string' && value.trim() !== '') {
        // Check if the string looks like JSON
        if (value.trim().startsWith('{') || value.trim().startsWith('[')) {
            try {
                return JSON.parse(value);
            } catch (e) {
                // If JSON parsing fails, treat as HTML
                console.error('Error parsing JSON content:', e);
                return value;
            }
        } else {
            // It's HTML content
            return value;
        }
    }
    
    // For non-string values, return as is
    return value || '';
};

// Determine content type and format it properly
const formatContentForEditor = () => {
    const value = props.modelValue;
    
    if (typeof value === 'string' && value.trim() !== '') {
        // Check if it's JSON format
        if (value.startsWith('{') || value.startsWith('[')) {
            try {
                return JSON.parse(value);
            } catch (e) {
                // If not valid JSON, return as HTML
                return value;
            }
        } else {
            // It's HTML content
            return value;
        }
    }
    
    // For objects (already parsed JSON) or other cases
    return value || '';
};

const editor = useEditor({
    content: formatContentForEditor(),
    extensions: [
        StarterKit,
        CustomImage.configure({
            inline: true,
        }),
        Underline,
        TextAlign.configure({
            types: ["heading", "paragraph"],
        }),
        Strike,
        Heading,
        ListItem,
        BulletList,
        OrderedList,
    ],
    editorProps: {
        attributes: {
            class: 'prose prose-sm sm:prose lg:prose-lg xl:prose-2xl focus:outline-none min-h-full',
        },
    },
    onUpdate: () => {
        // Output JSON instead of HTML
        const content = editor.value?.getJSON() || {};
        emit("update:modelValue", JSON.stringify(content));
    },
    onFocus: () => {
        // Update image selection state when editor is focused
        updateImageSelection();
    },
    onBlur: () => {
        // Reset image selection state when editor loses focus
        imageSelected.value = false;
    },
});

// Watch for changes in the editor to update image alignment
onMounted(() => {
    if (editor.value) {
        // Set up the transaction listener for image selection
        editor.value.on("transaction", updateImageSelection);

        // Set up focus and blur listeners
        editor.value.on("focus", () => {
            updateImageSelection();
        });

        editor.value.on("blur", () => {
            imageSelected.value = false;
        });
    }
});

// Watch for changes in modelValue and update editor content accordingly
watch(() => props.modelValue, (newValue) => {
    if (editor.value && newValue !== JSON.stringify(editor.value.getJSON())) {
        // Format the new value appropriately
        let contentToSet;
        if (typeof newValue === 'string' && (newValue.startsWith('{') || newValue.startsWith('['))) {
            try {
                contentToSet = JSON.parse(newValue);
            } catch {
                contentToSet = newValue;
            }
        } else {
            contentToSet = newValue;
        }
        
        // Set the new content
        editor.value.commands.setContent(contentToSet, false);
    }
});

// Clean up object URLs to prevent memory leaks
onUnmounted(() => {
    // Clean up any object URLs if they exist
    if (editor.value) {
        const images = editor.value.view.dom.querySelectorAll("img");
        images.forEach((img) => {
            if (img.src.startsWith("blob:")) {
                URL.revokeObjectURL(img.src);
            }
        });
    }
});
</script>

<template>
    <div class="tiptap-editor flex flex-col w-full h-full border border-gray-300 rounded-lg p-4 bg-white">
        <div class="toolbar mb-2 flex flex-wrap gap-2 border border-gray-300 rounded p-1 bg-gray-50">
            <!-- Text Formatting -->
            <button
                @click="editor?.chain().focus().toggleBold().run()"
                :class="{ 'bg-blue-500 text-white': editor?.isActive('bold') }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Bold"
            >
                <span class="font-bold">B</span>
            </button>
            <button
                @click="editor?.chain().focus().toggleItalic().run()"
                :class="{
                    'bg-blue-500 text-white': editor?.isActive('italic'),
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Italic"
            >
                <span class="italic">I</span>
            </button>
            <button
                @click="editor?.chain().focus().toggleUnderline().run()"
                :class="{
                    'bg-blue-500 text-white': editor?.isActive('underline'),
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Underline"
            >
                <span class="underline">U</span>
            </button>
            <button
                @click="editor?.chain().focus().toggleStrike().run()"
                :class="{
                    'bg-blue-500 text-white': editor?.isActive('strike'),
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Strikethrough"
            >
                <span class="line-through">S</span>
            </button>

            <!-- Headings -->
            <button
                @click="
                    editor?.chain().focus().toggleHeading({ level: 1 }).run()
                "
                :class="{
                    'bg-blue-500 text-white': editor?.isActive('heading', {
                        level: 1,
                    }),
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Heading 1"
            >
                H1
            </button>
            <button
                @click="
                    editor?.chain().focus().toggleHeading({ level: 2 }).run()
                "
                :class="{
                    'bg-blue-500 text-white': editor?.isActive('heading', {
                        level: 2,
                    }),
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Heading 2"
            >
                H2
            </button>
            <button
                @click="
                    editor?.chain().focus().toggleHeading({ level: 3 }).run()
                "
                :class="{
                    'bg-blue-500 text-white': editor?.isActive('heading', {
                        level: 3,
                    }),
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Heading 3"
            >
                H3
            </button>

            <!-- Lists -->
            <button
                @click="editor?.chain().focus().toggleBulletList().run()"
                :class="{
                    'bg-blue-500 text-white': editor?.isActive('bulletList'),
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Bullet List"
            >
                • List
            </button>
            <button
                @click="editor?.chain().focus().toggleOrderedList().run()"
                :class="{
                    'bg-blue-500 text-white': editor?.isActive('orderedList'),
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Numbered List"
            >
                1. List
            </button>

            <!-- Text Alignment -->
            <button
                @click="editor?.chain().focus().setTextAlign('left').run()"
                :class="{
                    'bg-blue-500 text-white': editor?.isActive({
                        textAlign: 'left',
                    }),
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Align Left"
            >
                ←
            </button>
            <button
                @click="editor?.chain().focus().setTextAlign('center').run()"
                :class="{
                    'bg-blue-500 text-white': editor?.isActive({
                        textAlign: 'center',
                    }),
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Align Center"
            >
                ↔
            </button>
            <button
                @click="editor?.chain().focus().setTextAlign('right').run()"
                :class="{
                    'bg-blue-500 text-white': editor?.isActive({
                        textAlign: 'right',
                    }),
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Align Right"
            >
                →
            </button>

            <!-- Image Insertion -->
            <button
                @click="addImage"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                title="Insert Image"
            >
                Insert Image
            </button>

            <!-- Image Alignment -->
            <button
                @click="editor?.chain().focus().setImageAlignment('left').run()"
                :class="{
                    'bg-blue-500 text-white': currentImageAlignment === 'left',
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                :disabled="!imageSelected"
                title="Float Left"
            >
                Float Left
            </button>
            <button
                @click="
                    editor?.chain().focus().setImageAlignment('center').run()
                "
                :class="{
                    'bg-blue-500 text-white':
                        currentImageAlignment === 'center',
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                :disabled="!imageSelected"
                title="Center Image"
            >
                Center
            </button>
            <button
                @click="
                    editor?.chain().focus().setImageAlignment('right').run()
                "
                :class="{
                    'bg-blue-500 text-white': currentImageAlignment === 'right',
                }"
                class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300"
                type="button"
                :disabled="!imageSelected"
                title="Float Right"
            >
                Float Right
            </button>
        </div>
        <editor-content :editor="editor" class="flex-1 border border-gray-300 rounded p-4 bg-white overflow-y-auto min-h-[400px]" />
        <input
            ref="imageInput"
            type="file"
            accept="image/*"
            class="hidden"
            @change="handleImageUpload"
        />
    </div>
</template>

<style>
/* Make sure the ProseMirror editor fills the available space */
.tiptap :deep(.ProseMirror) {
    min-height: 100%;
    height: 100%;
    outline: none;
}

/* These styles are mainly for custom image alignment */
.tiptap :deep(.inline-image[data-align="left"]) {
    float: left;
    margin-right: 1rem;
    max-width: 40%;
    height: 200px;
    object-fit: cover;
}

.tiptap :deep(.inline-image[data-align="right"]) {
    float: right;
    margin-left: 1rem;
    max-width: 40%;
    height: 200px;
    object-fit: cover;
}

.tiptap :deep(.inline-image[data-align="center"]) {
    display: block;
    margin-left: auto;
    margin-right: auto;
    height: 250px;
    width: auto;
    max-width: 100%;
    object-fit: cover;
}

/* Placeholder text for empty editor */
.tiptap-editor :deep(p.is-editor-empty:first-child::before) {
    color: #adb5bd;
    content: attr(data-placeholder);
    float: left;
    height: 0;
    pointer-events: none;
}

/* Image alignment styles */
.tiptap :deep(.inline-image) {
    max-width: 100%;
    height: auto;
    border-radius: 0.25rem;
    margin-top: 0.5em;
    margin-bottom: 0.5em;
    object-fit: cover; /* Ensures images maintain aspect ratio when constrained */
}

.tiptap :deep(.inline-image[data-align="left"]) {
    float: left;
    margin-right: 1rem;
    max-width: 40%;
    height: 200px;
    object-fit: cover;
}

.tiptap :deep(.inline-image[data-align="right"]) {
    float: right;
    margin-left: 1rem;
    max-width: 40%;
    height: 200px;
    object-fit: cover;
}

.tiptap :deep(.inline-image[data-align="center"]) {
    display: block;
    margin-left: auto;
    margin-right: auto;
    height: 250px;
    width: auto;
    max-width: 100%;
    object-fit: cover;
}
</style>
