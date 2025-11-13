<template>
  <div class="tinymce-editor-container">
    <Editor
      v-model="content"
      api-key="ii6kgr0mow8q0a947mym7e9hgmq6nzhznu4udxh523546oit"
      :init="{
        height: 500,
        menubar: false,
        toolbar_mode: 'sliding',
        plugins: [
          // Core editing features
          'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
          // Premium features
          'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'advtemplate', 'ai', 'uploadcare', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
        ],
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography uploadcare | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        mergetags_list: [
          { value: 'First.Name', title: 'First Name' },
          { value: 'Email', title: 'Email' },
        ],
        ai_request: (request, respondWith) => respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
        uploadcare_public_key: 'a3953b79e0bb0b71f5de',
        images_upload_handler: handleImageUpload, // Enable image upload
      }"
      @input="updateContent"
    />
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import Editor from '@tinymce/tinymce-vue';

interface Props {
  modelValue: string;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:modelValue']);

// Initialize content with modelValue or empty string if null/undefined
const content = ref(props.modelValue || '');

// Watch for changes in the modelValue and update the content accordingly
watch(
  () => props.modelValue,
  (newValue) => {
    if (newValue !== content.value) {
      content.value = newValue || '';
    }
  }
);

const updateContent = (newContent: string) => {
  emit('update:modelValue', newContent);
};

// Define TinyMCE skin and content CSS (using default values)
const tinyMCESkin = 'oxide';
const tinyMCEContentCss = 'default';

// Function to handle image uploads
const handleImageUpload = (blobInfo: any, progress: (value: number) => void) => {
  return new Promise((resolve, reject) => {
    const formData = new FormData();
    formData.append('image', blobInfo.blob(), blobInfo.filename());

    // Replace with your Laravel image upload endpoint
    fetch('/upload-image', {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.url) {
        resolve(data.url);
      } else {
        reject('Failed to upload image');
      }
    })
    .catch(error => {
      console.error('Error uploading image:', error);
      reject('HTTP Error occurred');
    });
  });
};
</script>

<style scoped>
.tinymce-editor-container {
  margin: 10px 0;
}
</style>
