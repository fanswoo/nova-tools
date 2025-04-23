<template>
  <button
    ref="codeButton"
    type="button"
    :class="{ 'is-active': editor?.isActive('code') }"
    @click="editor.chain().focus().toggleCode().run()"
  >
    <FontAwesomeIcon icon="code" />
  </button>
</template>

<script setup lang="ts">
import { ref, onMounted, inject } from 'vue';
import tippy from 'tippy.js';

const codeButton = ref(null);
const editor = inject('editor');

onMounted(() => {
  tippy(codeButton.value, {
    content: '標註',
    theme: 'tooltip',
  });
});
</script>

<script lang="ts">
export default {
  name: 'CodeButton',
};
</script>
