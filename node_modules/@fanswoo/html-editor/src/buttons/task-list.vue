<template>
  <button
    ref="taskListButton"
    type="button"
    :class="{ 'is-active': editor?.isActive('taskList') }"
    @click="editor.chain().focus().toggleTaskList().run()"
  >
    <FontAwesomeIcon icon="tasks" />
  </button>
</template>

<script lang="ts" setup>
import { ref, onMounted, inject } from 'vue';
import tippy from 'tippy.js';

const editor: any = inject('editor');
const taskListButton = ref(null);

onMounted(() => {
  tippy(taskListButton.value, {
    content: '任務清單',
    theme: 'tooltip',
  });
});
</script>
