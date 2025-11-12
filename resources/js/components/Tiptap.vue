<template>
  <div ref="editorContainer" class="tiptap-editor-container">
    <div class="tiptap-editor-toolbar">
      <button @click="editor?.chain().focus().toggleBold().run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive('bold') }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M8 5h8a4 4 0 0 1 0 8H8V5z"></path>
          <path d="M8 13h6a4 4 0 0 1 0 8H8v-8z"></path>
        </svg>
      </button>
      <button @click="editor?.chain().focus().toggleItalic().run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive('italic') }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="19" y1="4" x2="10" y2="4"></line>
          <line x1="14" y1="20" x2="5" y2="20"></line>
          <line x1="15" y1="4" x2="9" y2="20"></line>
        </svg>
      </button>
      <button @click="editor?.chain().focus().toggleUnderline().run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive('underline') }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M6 4v6a6 6 0 0 0 12 0V4"></path>
          <line x1="4" y1="20" x2="20" y2="20"></line>
        </svg>
      </button>
      <button @click="editor?.chain().focus().toggleStrike().run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive('strike') }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M16 4H9a3 3 0 0 0-2.83 4"></path>
          <path d="M14 12a4 4 0 0 1 0 8H6"></path>
          <line x1="4" y1="12" x2="20" y2="12"></line>
        </svg>
      </button>
      <div class="border-l border-gray-200 h-6 mx-2"></div>
      <button @click="editor?.chain().focus().toggleHeading({ level: 1 }).run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive('heading', { level: 1 }) }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        H1
      </button>
      <button @click="editor?.chain().focus().toggleHeading({ level: 2 }).run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive('heading', { level: 2 }) }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        H2
      </button>
      <button @click="editor?.chain().focus().toggleHeading({ level: 3 }).run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive('heading', { level: 3 }) }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        H3
      </button>
      <div class="border-l border-gray-200 h-6 mx-2"></div>
      <button @click="editor?.chain().focus().toggleBulletList().run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive('bulletList') }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="8" y1="6" x2="21" y2="6"></line>
          <line x1="8" y1="12" x2="21" y2="12"></line>
          <line x1="8" y1="18" x2="21" y2="18"></line>
          <line x1="3" y1="6" x2="3.01" y2="6"></line>
          <line x1="3" y1="12" x2="3.01" y2="12"></line>
          <line x1="3" y1="18" x2="3.01" y2="18"></line>
        </svg>
      </button>
      <button @click="editor?.chain().focus().toggleOrderedList().run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive('orderedList') }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="10" y1="6" x2="21" y2="6"></line>
          <line x1="10" y1="12" x2="21" y2="12"></line>
          <line x1="10" y1="18" x2="21" y2="18"></line>
          <path d="M4 6h1v4H4V6z"></path>
          <path d="M4 10h2v4H4v-4z"></path>
          <path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"></path>
        </svg>
      </button>
      <button @click="editor?.chain().focus().setTextAlign('left').run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive({ textAlign: 'left' }) }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="21" y1="10" x2="3" y2="10"></line>
          <line x1="21" y1="6" x2="3" y2="6"></line>
          <line x1="21" y1="14" x2="3" y2="14"></line>
          <line x1="21" y1="18" x2="9" y2="18"></line>
        </svg>
      </button>
      <button @click="editor?.chain().focus().setTextAlign('center').run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive({ textAlign: 'center' }) }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="21" y1="10" x2="3" y2="10"></line>
          <line x1="21" y1="6" x2="3" y2="6"></line>
          <line x1="21" y1="14" x2="3" y2="14"></line>
          <line x1="21" y1="18" x2="3" y2="18"></line>
        </svg>
      </button>
      <button @click="editor?.chain().focus().setTextAlign('right').run()" 
              :class="{ 'bg-blue-500 text-white': editor?.isActive({ textAlign: 'right' }) }"
              class="p-2 rounded hover:bg-gray-100 border border-gray-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="21" y1="10" x2="3" y2="10"></line>
          <line x1="21" y1="6" x2="3" y2="6"></line>
          <line x1="21" y1="14" x2="3" y2="14"></line>
          <line x1="21" y1="18" x2="3" y2="18"></line>
        </svg>
      </button>
    </div>
    <editor-content :editor="editor" class="tiptap-editor-content" />
  </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue'
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import TextAlign from '@tiptap/extension-text-align'
import Heading from '@tiptap/extension-heading'

const props = defineProps({
  modelValue: {
    type: [String, Object],
    default: () => ({ type: "doc", content: [{ type: "paragraph", content: [] }] }),
  },
})

const emit = defineEmits(['update:modelValue'])

const editorContainer = ref(null)

const editor = useEditor({
  content: typeof props.modelValue === 'string' && props.modelValue.trim() !== '' 
    ? JSON.parse(props.modelValue) 
    : (typeof props.modelValue === 'object' && props.modelValue !== null)
      ? props.modelValue
      : { type: "doc", content: [{ type: "paragraph", content: [] }] },
  extensions: [
    StarterKit,
    Underline,
    TextAlign.configure({
      types: ['heading', 'paragraph'],
    }),
    Heading.configure({
      levels: [1, 2, 3, 4, 5, 6],
    }),
  ],
  onUpdate: () => {
    emit('update:modelValue', editor.value?.getJSON())
  },
})

// Initialize the editor with the model value
watch(() => props.modelValue, (newValue) => {
  let contentToCompare = newValue;
  if (typeof newValue === 'string') {
    try {
      contentToCompare = JSON.parse(newValue);
    } catch {
      contentToCompare = newValue;
    }
  }

  const isSame = JSON.stringify(editor.value?.getJSON()) === JSON.stringify(contentToCompare)
  
  if (isSame) {
    return
  }

  editor.value?.commands.setContent(contentToCompare, false)
}, { immediate: true })

onMounted(() => {
  // The editor is already initialized with the proper content in useEditor
  // No need to set content again here
})


</script>

<style scoped>
.tiptap-editor-container {
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  overflow: hidden;
  background-color: white;
}

.tiptap-editor-toolbar {
  display: flex;
  flex-wrap: wrap;
  gap: 0.25rem;
  padding: 0.5rem;
  border-bottom: 1px solid #e5e7eb;
  background-color: #f9fafb;
}

.tiptap-editor-content {
  padding: 1rem;
}

.tiptap-editor-content :deep(.ProseMirror) {
  min-height: 300px;
  outline: none;
}

.tiptap-editor-content :deep(.ProseMirror-focused) {
  outline: none;
}
</style>