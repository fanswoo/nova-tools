<template>
  <button
    ref="orderedListButton"
    type="button"
    :class="{ 'is-active': editor?.isActive('orderedList') }"
    @click="editor.chain().focus().toggleOrderedList().run()"
  >
    <FontAwesomeIcon icon="list-ol" />
  </button>
</template>

<script lang="ts" setup>
import { ref, onMounted, inject } from 'vue';
import tippy from 'tippy.js';

const editor: any = inject('editor');
const orderedListButton = ref(null);

onMounted(() => {
  tippy(orderedListButton.value, {
    content: '有序清單',
    theme: 'tooltip',
  });
});
</script>
