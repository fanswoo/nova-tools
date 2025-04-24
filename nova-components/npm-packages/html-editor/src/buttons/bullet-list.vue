<template>
  <button
    ref="bulletListButton"
    type="button"
    :class="{ 'is-active': editor?.isActive('bulletList') }"
    @click="editor.chain().focus().toggleBulletList().run()"
  >
    <FontAwesomeIcon icon="list" />
  </button>
</template>

<script setup lang="ts">
import { ref, onMounted, inject } from 'vue';
import tippy from 'tippy.js';

const bulletListButton = ref(null);
const editor = inject('editor');

onMounted(() => {
  tippy(bulletListButton.value, {
    content: '符號清單',
    theme: 'tooltip',
  });
});
</script>
