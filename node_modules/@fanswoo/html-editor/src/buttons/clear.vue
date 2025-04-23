<template>
  <button
    ref="clearButton"
    type="button"
    @click="editor.chain().focus().unsetAllMarks().clearNodes().run()"
  >
    <FontAwesomeIcon icon="ban" />
  </button>
</template>

<script setup lang="ts">
import { ref, onMounted, inject } from 'vue';
import tippy from 'tippy.js';

const clearButton = ref(null);
const editor = inject('editor');

onMounted(() => {
  tippy(clearButton.value, {
    content: '清除格式',
    theme: 'tooltip',
  });
});
</script>
