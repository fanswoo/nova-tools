<template>
  <div class="font-size-toggle-button">
    <button
      ref="textSizeButton"
      type="button"
      @click="togglePanel"
    >
      <FontAwesomeIcon icon="text-height" />
    </button>
    <div
      :class="{
        'font-size-panel': true,
        'is-open': isOpen,
      }"
    >
      <button
        type="button"
        :class="{
          'font-size-button': true,
        }"
        @click="editor.chain().focus().unsetFontSize().run() && closePanel()"
      >
        預設大小
      </button>
      <button
        type="button"
        v-for="size in sizes"
        :class="{
          'font-size-button': true,
          'is-active': editor?.isActive('textStyle', {
            fontSize: size,
          }),
        }"
        @click="editor.chain().focus().setFontSize(size).run() && closePanel()"
      >
        {{ size }}
      </button>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { inject, onMounted, ref } from 'vue';
import tippy from 'tippy.js';

const editor: any = inject('editor');

const isOpen = ref(false);

const sizes = [12, 14, 16, 20, 24, 28, 32, 36, 48, 60, 72];
const textSizeButton = ref(null);

onMounted(() => {
  tippy(textSizeButton.value, {
    content: '文字大小',
    theme: 'tooltip',
  });
});

const closePanel = () => {
  isOpen.value = false;
};

const togglePanel = () => {
  isOpen.value = !isOpen.value;
};

document.addEventListener('click', (event: any) => {
  if (
    isOpen.value &&
    !textSizeButton.value.contains(event.target)
  ) {
    closePanel();
  }
});
</script>
