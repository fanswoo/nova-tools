<template>
  <div
    class="editor-menu"
    ref="editorMenu"
    :style="{
      top: `${menuStickyTop}px`,
      zIndex
    }"
  >
    <slot />
  </div>
</template>

<script lang="ts" setup>
import { ref, onMounted, inject } from 'vue';

const { menuStickyTop } = defineProps({
  menuStickyTop: {
    type: Number,
    default: 0,
  },
});

const zIndex = ref(1000);

const hideFirstAndLastItem = () => {
  let flexChildren = document.querySelectorAll('.editor-menu > *');
  let leftPosition: number = flexChildren && flexChildren[0] && flexChildren[0].offsetLeft ? flexChildren[0].offsetLeft : 0;
  for (let flexChild of flexChildren) {
    flexChild.classList.remove('is-first-item');
    if (flexChild.offsetLeft <= leftPosition) {
      flexChild.classList.add('is-first-item');
    }
  }
};

const editor: any = inject('editor');
const editorMenu = ref(null);

editor.value.on('create', () => {
  window.addEventListener('resize', hideFirstAndLastItem);
  hideFirstAndLastItem();
});

onMounted(() => {
  const editorMenus = document.querySelectorAll('.editor-menu');
  const index = Object.values(editorMenus).indexOf(editorMenu.value);
  zIndex.value = zIndex.value - index;
});
</script>

<style lang="scss">
@import '@fanswoo/html-editor/style/editor-menu.scss';
</style>
