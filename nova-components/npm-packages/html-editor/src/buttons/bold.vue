<template>
  <button
    ref="boldButton"
    type="button"
    :class="{ 'is-active': editor?.isActive('bold') }"
    @click="editor.chain().focus().toggleBold().run()"
  >
    <FontAwesomeIcon icon="bold" />
  </button>
</template>

<script lang="ts" setup>
import { inject, ref, onMounted } from 'vue';
import tippy from 'tippy.js';

const editor = inject('editor');
const boldButton = ref(null);

onMounted(() => {
  tippy(boldButton.value, {
    content: '粗體',
    theme: 'tooltip',
  });
});
</script>
