<template>
  <Editor
    :editor="editor"
    :inputName="inputName"
    :maxWidth="maxWidth"
  >
    <EditorMenu :menuStickyTop="menuStickyTop">
      <BoldButton />
      <ItalicButton />
      <BulletListButton />
      <OrderedListButton />
      <ClearButton />
    </EditorMenu>
    <EditorContent :editor="editor" class="content" />
  </Editor>
</template>

<script lang="ts" setup>
import {
  createEditor,
  Editor,
  EditorMenu,
  EditorContent,
} from '@fanswoo/html-editor/core/editor-core';
import { ref, watch } from 'vue';
import BoldButton from '@fanswoo/html-editor/buttons/bold.vue';
import ClearButton from '@fanswoo/html-editor/buttons/clear.vue';
import ItalicButton from '@fanswoo/html-editor/buttons/italic.vue';
import BulletListButton from '@fanswoo/html-editor/buttons/bullet-list.vue';
import OrderedListButton from '@fanswoo/html-editor/buttons/ordered-list.vue';

const props = defineProps({
  inputName: {
    type: String,
    default: '',
  },
  placeholder: {
    type: String,
    default: '請輸入內容 ...',
  },
  menuStickyTop: {
    type: Number,
    default: 0,
  },
  width: {
    type: Number,
    default: 0,
  },
  height: {
    type: Number,
    default: 0,
  },
  minHeight: {
    type: Number,
    default: 100,
  },
  maxHeight: {
    type: Number,
    default: 500,
  },
  maxWidth: {
    type: Number,
    default: 800,
  },
});

const content = defineModel();

const { editor } = createEditor({
  content,
  props
});
</script>
