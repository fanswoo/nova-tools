<template>
  <button
    ref="strikeButton"
    type="button"
    :class="{ 'is-active': editor?.isActive('strike') }"
    @click="editor.chain().focus().toggleStrike().run()"
  >
    <FontAwesomeIcon icon="strikethrough" />
  </button>
</template>

<script lang="ts" setup>
import { ref, onMounted, inject } from 'vue';
import tippy from 'tippy.js';

const editor: any = inject('editor');
const strikeButton = ref(null);

onMounted(() => {
  tippy(strikeButton.value, {
    content: '刪除線',
    theme: 'tooltip',
  });
});
</script>
