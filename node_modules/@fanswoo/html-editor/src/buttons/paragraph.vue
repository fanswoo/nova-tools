<template>
  <div class="paragraph-toggle-button">
    <button
      ref="paragraphButton"
      type="button"
      :class="{
        'toggle-button': true,
        'fade-out': displayText === textItems.none,
      }"
      @click="togglePanel"
    >
      {{ displayText }}
      <FontAwesomeIcon icon="caret-down"/>
    </button>
    <div
      :class="{
        'paragraph-panel': true,
        'is-open': isOpen,
      }"
    >
      <button
        type="button"
        :class="{
          'paragraph-button': true,
          'is-active': editor.isActive('heading', { level: 1 }),
        }"
        :style="{ 'font-weight': 900 }"
        @click="
          editor.chain().focus().toggleHeading({ level: 1 }).run() &&
            closePanel()
        "
      >
        {{ textItems.h1 }}
      </button>
      <button
        type="button"
        :class="{
          'paragraph-button': true,
          'is-active': editor.isActive('heading', { level: 2 }),
        }"
        :style="{ 'font-weight': 800 }"
        @click="
          editor.chain().focus().toggleHeading({ level: 2 }).run() &&
            closePanel()
        "
      >
        {{ textItems.h2 }}
      </button>
      <button
        type="button"
        :class="{
          'paragraph-button': true,
          'is-active': editor.isActive('heading', { level: 3 }),
        }"
        :style="{ 'font-weight': 700 }"
        @click="
          editor.chain().focus().toggleHeading({ level: 3 }).run() &&
            closePanel()
        "
      >
        {{ textItems.h3 }}
      </button>
      <button
        type="button"
        :class="{
          'paragraph-button': true,
          'is-active': editor.isActive('heading', { level: 4 }),
        }"
        :style="{ 'font-weight': 600 }"
        @click="
          editor.chain().focus().toggleHeading({ level: 4 }).run() &&
            closePanel()
        "
      >
        {{ textItems.h4 }}
      </button>
      <button
        type="button"
        :class="{
          'paragraph-button': true,
          'is-active': editor.isActive('heading', { level: 5 }),
        }"
        :style="{ 'font-weight': 500 }"
        @click="
          editor.chain().focus().toggleHeading({ level: 5 }).run() &&
            closePanel()
        "
      >
        {{ textItems.h5 }}
      </button>
      <button
        type="button"
        :class="{
          'paragraph-button': true,
          'is-active': editor.isActive('heading', { level: 6 }),
        }"
        :style="{ 'font-weight': 400 }"
        @click="
          editor.chain().focus().toggleHeading({ level: 6 }).run() &&
            closePanel()
        "
      >
        {{ textItems.h6 }}
      </button>
      <button
        type="button"
        :class="{
          'paragraph-button': true,
          'is-active': editor.isActive('paragraph'),
        }"
        :style="{ 'font-weight': 300 }"
        @click="editor.chain().focus().setParagraph().run() && closePanel()"
      >
        {{ textItems.paragraph }}
      </button>
    </div>
  </div>
</template>

<script lang="ts" setup>
import {ref, computed, inject, onMounted} from 'vue';
import tippy from 'tippy.js';

const textItems = {
  paragraph: '文字段落',
  h1: '標題 H1',
  h2: '標題 H2',
  h3: '標題 H3',
  h4: '標題 H4',
  h5: '標題 H5',
  h6: '標題 H6',
  none: '不可選擇',
};

const paragraphButton = ref(null);

onMounted(() => {
  tippy(paragraphButton.value, {
    content: '段落',
    theme: 'tooltip',
  });
});

const editor: any = inject('editor');

const isOpen = ref(false);

const displayText = computed(() => {
  let text: string;

  if (editor.value.isActive('paragraph')) {
    text = textItems.paragraph;
  }

  if (editor.value.isActive('heading', {level: 1})) {
    text = textItems.h1;
  }

  if (editor.value.isActive('heading', {level: 2})) {
    text = textItems.h2;
  }

  if (editor.value.isActive('heading', {level: 3})) {
    text = textItems.h3;
  }

  if (editor.value.isActive('heading', {level: 4})) {
    text = textItems.h4;
  }

  if (editor.value.isActive('heading', {level: 5})) {
    text = textItems.h5;
  }

  if (editor.value.isActive('heading', {level: 6})) {
    text = textItems.h6;
  }

  if (text === undefined) {
    text = textItems.none;
  }

  return text;
});

const togglePanel = () => {
  isOpen.value = !isOpen.value;
};

const closePanel = () => {
  isOpen.value = false;
};

document.addEventListener('click', (event: any) => {
  if (
    isOpen.value &&
    !paragraphButton.value.contains(event.target)
  ) {
    closePanel();
  }
});
</script>

<style lang="scss" scoped>
.toggle-button {
  padding: 0 3px;
}
</style>