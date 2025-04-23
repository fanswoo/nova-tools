<template>
  <button
    ref="horizontalRuleButton"
    type="button"
    @click="editor.chain().focus().setHorizontalRule().run()"
  >
    <FontAwesomeIcon icon="grip-lines" />
  </button>
</template>

<script lang="ts" setup>
import { ref, onMounted, inject } from 'vue';
import tippy from 'tippy.js';

const editor: any = inject('editor');
const horizontalRuleButton = ref(null);

onMounted(() => {
  tippy(horizontalRuleButton.value, {
    content: '水平線',
    theme: 'tooltip',
  });
});
</script>
