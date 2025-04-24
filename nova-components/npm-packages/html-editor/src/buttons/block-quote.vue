<template>
  <button
    ref="blockQuoteButton"
    type="button"
    :class="{ 'is-active': editor?.isActive('blockquote') }"
    @click="editor.chain().focus().toggleBlockquote().run()"
  >
    <FontAwesomeIcon icon="quote-left" />
  </button>
</template>

<script setup lang="ts">
import { ref, onMounted, inject } from 'vue';
import tippy from 'tippy.js';

const blockQuoteButton = ref(null);
const editor = inject('editor');

onMounted(() => {
  tippy(blockQuoteButton.value, {
    content: '引述區塊',
    theme: 'tooltip',
  });
});
</script>
