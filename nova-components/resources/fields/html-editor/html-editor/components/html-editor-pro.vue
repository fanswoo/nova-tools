<template>
  <Editor
    :editor="editor"
    :inputName="inputName"
    :maxWidth="maxWidth"
  >
    <EditorMenu :menuStickyTop="menuStickyTop">
      <ParagraphButton />
      <TextSizeButton />
      <ColorButton />
      <HighlightButton />
      <Separator />
      <BoldButton />
      <ItalicButton />
      <StrikeButton />
      <UnderlineButton />
      <CodeButton />
      <Separator />
      <TextAlignButton />
      <BulletListButton />
      <OrderedListButton />
      <TaskListButton />
      <Separator />
      <LinkButton />
      <ImageButton
        :inputNamePic="inputNamePic"
        @onPicIdsChange="onPicIdsChange"
      />
      <TableButton />
      <BlockQuoteButton />
      <CodeBlockButton />
      <Separator />
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
import HighlightButton from '@fanswoo/html-editor/buttons/highlight.vue';
import BoldButton from '@fanswoo/html-editor/buttons/bold.vue';
import StrikeButton from '@fanswoo/html-editor/buttons/strike.vue';
import ClearButton from '@fanswoo/html-editor/buttons/clear.vue';
import CodeButton from '@fanswoo/html-editor/buttons/code.vue';
import ItalicButton from '@fanswoo/html-editor/buttons/italic.vue';
import ParagraphButton from '@fanswoo/html-editor/buttons/paragraph.vue';
import TextAlignButton from '@fanswoo/html-editor/buttons/text-align.vue';
import LinkButton from '@fanswoo/html-editor/buttons/link.vue';
import ImageButton from '@fanswoo/html-editor/buttons/image.vue';
import UnderlineButton from '@fanswoo/html-editor/buttons/underline.vue';
import BlockQuoteButton from '@fanswoo/html-editor/buttons/block-quote.vue';
import BulletListButton from '@fanswoo/html-editor/buttons/bullet-list.vue';
import CodeBlockButton from '@fanswoo/html-editor/buttons/code-block.vue';
import OrderedListButton from '@fanswoo/html-editor/buttons/ordered-list.vue';
import TaskListButton from '@fanswoo/html-editor/buttons/task-list.vue';
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
