<template>
  <button
    ref="codeBlockButton"
    type="button"
    :class="{ 'is-active': editor?.isActive('codeBlock') }"
    @click="editor.chain().focus().toggleCodeBlock().run()"
  >
    <FontAwesomeIcon icon="window-maximize" />
  </button>
</template>

<script lang="ts" setup>
import { ref, onMounted, inject } from 'vue';
import tippy from 'tippy.js';

const editor = inject('editor');
const codeBlockButton = ref(null);

onMounted(() => {
  tippy(codeBlockButton.value, {
    content: '程式碼區塊',
    theme: 'tooltip',
  });
});
</script>
