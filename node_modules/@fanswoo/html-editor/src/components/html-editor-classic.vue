<template>
  <Editor
    :editor="editor"
    :inputName="inputName"
    :maxWidth="maxWidth"
  >
    <EditorMenu :menuStickyTop="menuStickyTop">
      <TextSizeButton />
      <ColorButton />
      <BoldButton />
      <ItalicButton />
      <Separator />
      <TextAlignButton />
      <BulletListButton />
      <OrderedListButton />
      <Separator />
      <LinkButton />
      <ImageButton
        :inputNamePic="inputNamePic"
        @onPicIdsChange="onPicIdsChange"
      />
      <TableButton />
      <YoutubeButton />
      <EmbedButton />
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
import { watch } from 'vue';
import ColorButton from '@fanswoo/html-editor/buttons/color.vue';
import TextSizeButton from '@fanswoo/html-editor/buttons/text-size.vue';
import BoldButton from '@fanswoo/html-editor/buttons/bold.vue';
import ClearButton from '@fanswoo/html-editor/buttons/clear.vue';
import ItalicButton from '@fanswoo/html-editor/buttons/italic.vue';
import TextAlignButton from '@fanswoo/html-editor/buttons/text-align.vue';
import LinkButton from '@fanswoo/html-editor/buttons/link.vue';
import ImageButton from '@fanswoo/html-editor/buttons/image.vue';
import BulletListButton from '@fanswoo/html-editor/buttons/bullet-list.vue';
import OrderedListButton from '@fanswoo/html-editor/buttons/ordered-list.vue';
import YoutubeButton from '@fanswoo/html-editor/buttons/youtube.vue';
import EmbedButton from '@fanswoo/html-editor/buttons/embed.vue';
import TableButton from '@fanswoo/html-editor/buttons/table.vue';
import Separator from '@fanswoo/html-editor/layouts/editor-menu/separator.vue';

const props = defineProps({
  inputName: {
    type: String,
    default: '',
  },
  inputNamePic: {
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

const emit = defineEmits(['onPicIdsChange']);
const content = defineModel();

const onPicIdsChange = (picIds: string[]) => {
  emit('onPicIdsChange', picIds);
};

const { editor } = createEditor({
  content,
  props
});
</script>
