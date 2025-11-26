<template>
    <div class="tinymce-editor-container">
        <Editor
            ref="editorRef"
            v-model="content"
            :id="editorId"
            api-key="ii6kgr0mow8q0a947mym7e9hgmq6nzhznu4udxh523546oit"
            :init="{
                height: 500,
                menubar: false,
                toolbar_mode: 'sliding',
                plugins: [
                    // Core editing features
                    'anchor',
                    'autolink',
                    'charmap',
                    'codesample',
                    'emoticons',
                    'link',
                    'lists',
                    'media',
                    'searchreplace',
                    'table',
                    'visualblocks',
                    'wordcount',
                    // Premium features
                    'checklist',
                    'mediaembed',
                    'casechange',
                    'formatpainter',
                    'pageembed',
                    'a11ychecker',
                    'tinymcespellchecker',
                    'permanentpen',
                    'powerpaste',
                    'advtable',
                    'advcode',
                    'advtemplate',
                    'ai',
                    'uploadcare',
                    'mentions',
                    'tinycomments',
                    'tableofcontents',
                    'footnotes',
                    'mergetags',
                    'autocorrect',
                    'typography',
                    'inlinecss',
                    'markdown',
                    'importword',
                    'exportword',
                    'exportpdf',
                ],
                toolbar:
                    'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                tinycomments_mode: 'embedded',
                tinycomments_author: 'Author name',
                mergetags_list: [
                    { value: 'First.Name', title: 'First Name' },
                    { value: 'Email', title: 'Email' },
                ],
                ai_request: (request, respondWith) =>
                    respondWith.string(() =>
                        Promise.reject('See docs to implement AI Assistant'),
                    ),
                content_style: `
                    ${'/* Import Tailwind-compatible styles */'}
                    body {
                        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                        font-size: 1rem;
                        line-height: 1.6;
                        color: #374151;
                        margin: 0;
                        padding: 1rem;
                    }
                    body .content-display h1, h1 {
                        font-size: 2.25rem;
                        font-weight: 700;
                        margin-top: 1.5rem;
                        margin-bottom: 1rem;
                        color: #111827;
                        line-height: 1.2;
                    }
                    body .content-display h2, h2 {
                        font-size: 1.875rem;
                        font-weight: 700;
                        margin-top: 1.5rem;
                        margin-bottom: 1rem;
                        color: #111827;
                        line-height: 1.25;
                    }
                    body .content-display h3, h3 {
                        font-size: 1.5rem;
                        font-weight: 700;
                        margin-top: 1.25rem;
                        margin-bottom: 0.75rem;
                        color: #111827;
                        line-height: 1.3;
                    }
                    body .content-display h4, h4 {
                        font-size: 1.25rem;
                        font-weight: 700;
                        margin-top: 1rem;
                        margin-bottom: 0.5rem;
                        color: #111827;
                        line-height: 1.4;
                    }
                    body .content-display h5, h5 {
                        font-size: 1.125rem;
                        font-weight: 700;
                        margin-top: 0.75rem;
                        margin-bottom: 0.5rem;
                        color: #111827;
                        line-height: 1.4;
                    }
                    body .content-display h6, h6 {
                        font-size: 1rem;
                        font-weight: 700;
                        margin-top: 0.5rem;
                        margin-bottom: 0.25rem;
                        color: #111827;
                        line-height: 1.5;
                    }
                    body .content-display p, p { margin-top: 1rem; margin-bottom: 1rem; line-height: 1.6; }
                    body .content-display a, a { color: #2563eb; text-decoration: underline; }
                    body .content-display a:hover, a:hover { color: #1d4ed8; }
                    body .content-display ul, body .content-display ol, ul, ol { margin-top: 1rem; margin-bottom: 1rem; padding-left: 1.5rem; }
                    body .content-display ul, ul { list-style-type: disc; }
                    body .content-display ol, ol { list-style-type: decimal; }
                    body .content-display li, li { margin-bottom: 0.25rem; }
                    body .content-display blockquote, blockquote {
                        border-left: 4px solid #d1d5db;
                        padding-left: 1rem;
                        margin-top: 1.5rem;
                        margin-bottom: 1.5rem;
                        color: #4b5563;
                        font-style: italic;
                    }
                    body .content-display pre, pre {
                        background-color: #f3f4f6;
                        padding: 1rem;
                        border-radius: 0.375rem;
                        margin-top: 1rem;
                        margin-bottom: 1rem;
                        color: #1f2937;
                        font-family: ui-monospace, SFMono-Regular, 'SF Mono', Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
                        overflow-x: auto;
                    }
                    body .content-display code, code {
                        font-family: ui-monospace, SFMono-Regular, 'SF Mono', Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace;
                        background-color: #f3f4f6;
                        padding: 0.25rem 0.375rem;
                        border-radius: 0.25rem;
                        font-size: 0.875rem;
                        color: #1f2937;
                    }
                    body .content-display pre code, pre code {
                        background-color: transparent;
                        padding: 0;
                        border-radius: 0;
                        color: #1f2937;
                    }
                    body .content-display hr, hr { border-top: 1px solid #d1d5db; margin: 1.5rem 0; }
                    body .content-display table, table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
                    body .content-display th, body .content-display td, th, td { padding: 0.75rem; text-align: left; border: 1px solid #e5e7eb; }
                    body .content-display th, th { background-color: #f9fafb; font-weight: 600; }
                    body .content-display img, img { margin: 1rem 0; }
                    body .content-display strong, body .content-display b, strong, b { font-weight: 700; }
                    body .content-display em, body .content-display i, em, i { font-style: italic; }
                    body .content-display u, u { text-decoration: underline; }
                    body .content-display s, body .content-display strike, s, strike { text-decoration: line-through; }
                    body .content-display mark, mark { background-color: #fef9c3; color: #1f2937; }
                `,
                body_class: 'content-display',
                uploadcare_public_key: 'a3953b79e0bb0b71f5de',
                images_upload_handler: handleImageUpload, // Enable image upload
            }"
            @input="updateContent"
        />
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import Editor from "@tinymce/tinymce-vue";

interface Props {
    modelValue: string;
}

const props = defineProps<Props>();
const emit = defineEmits(["update:modelValue"]);
const editorRef = ref();
const editorId = `tinymce-editor-${Date.now()}-${Math.floor(Math.random() * 1000)}`;

// Initialize content with modelValue or empty string if null/undefined
const content = ref(props.modelValue || "");

// Watch for changes in the modelValue and update the content accordingly
watch(
    () => props.modelValue,
    (newValue) => {
        if (newValue !== content.value) {
            content.value = newValue || "";
        }
    },
);

const updateContent = (newContent: string) => {
    content.value = newContent;  // Update internal ref
    emit("update:modelValue", newContent);
};

// Expose method to get editor content directly
defineExpose({
    getContent: () => {
        if (editorRef.value && editorRef.value.editor) {
            return editorRef.value.editor.getContent();
        }
        // Fallback to internal content ref
        return content.value;
    },
    getEditor: () => {
        return editorRef.value ? editorRef.value.editor : null;
    },
});

// Define TinyMCE skin and content CSS (using default values)
const tinyMCESkin = "oxide";
const tinyMCEContentCss = "default";

// Function to handle image uploads
const handleImageUpload = (
    blobInfo: any,
    progress: (value: number) => void,
) => {
    return new Promise((resolve, reject) => {
        const formData = new FormData();
        formData.append("image", blobInfo.blob(), blobInfo.filename());

        // Replace with your Laravel image upload endpoint
        fetch("/upload-image", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN":
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute("content") || "",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.url) {
                    resolve(data.url);
                } else {
                    reject("Failed to upload image");
                }
            })
            .catch((error) => {
                console.error("Error uploading image:", error);
                reject("HTTP Error occurred");
            });
    });
};
</script>

<style scoped>
.tinymce-editor-container {
    margin: 10px 0;
}
</style>
