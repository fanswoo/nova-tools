<template>
  <div
    v-if="editor"
    class="editor"
    :dusk="inputName"
    :style="{ 'max-width': maxWidth ? `${maxWidth}px` : 'auto' }"
  >
    <slot/>
  </div>
</template>

<script lang="ts" setup>
import {ref, watch} from 'vue';

const props = defineProps({
  maxWidth: {
    type: Number,
    default: 0,
  },
  inputName: {
    type: String,
    default: '',
  },
  editor: {
    type: Object,
    default: null,
  },
});

const {editor, maxWidth, inputName} = props;
</script>

<style lang="scss" scoped>
@import '@fanswoo/html-editor/style/editor.scss';
</style>
