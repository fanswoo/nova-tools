<template>
  <button
    ref="italicButton"
    type="button"
    :class="{ 'is-active': editor?.isActive('italic') }"
    @click="editor.chain().focus().toggleItalic().run()"
  >
    <FontAwesomeIcon icon="italic" />
  </button>
</template>

<script lang="ts" setup>
import { ref, onMounted, inject } from 'vue';
import tippy from 'tippy.js';

const editor: any = inject('editor');
const italicButton = ref(null);

onMounted(() => {
  tippy(italicButton.value, {
    content: '斜體',
    theme: 'tooltip',
  });
});
</script>
