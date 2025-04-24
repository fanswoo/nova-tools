<template>
  <button
    ref="underlineButton"
    type="button"
    :class="{ 'is-active': editor.isActive('underline') }"
    @click="editor.chain().focus().toggleUnderline().run()"
  >
    <FontAwesomeIcon icon="underline" />
  </button>
</template>

<script lang="ts" setup>
import { ref, onMounted, inject } from 'vue';
import tippy from 'tippy.js';

const editor: any = inject('editor');
const underlineButton = ref(null);

onMounted(() => {
  tippy(underlineButton.value, {
    content: '底線',
    theme: 'tooltip',
  });
});
</script>
