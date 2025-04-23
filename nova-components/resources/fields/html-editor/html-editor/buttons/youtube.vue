<template>
  <button
    ref="youtubeButton"
    type="button"
    @click="addVideo"
  >
    <FontAwesomeIcon icon="video"/>
  </button>
</template>

<script lang="ts" setup>
import {inject, onMounted, ref} from 'vue';
import tippy from 'tippy.js';

const editor: any = inject('editor');
const width = ref(640);
const height = ref(480);
const youtubeButton = ref(null);

onMounted(() => {
  tippy(youtubeButton.value, {
    content: '插入 Youtube',
    theme: 'tooltip',
  });
});

const addVideo = () => {
  let url = prompt('Enter YouTube URL');

  if (!url) {
    return;
  }

  if (isShortYoutubeUrl(url)) {
    url = transformShortYoutubeUrl(url);
  }

  editor.value.commands.setYoutubeVideo({
    src: url,
    width: Math.max(640, width.value) || 640,
    height: Math.max(480, height.value) || 480,
  });
};

const isShortYoutubeUrl = (url: string): boolean => {
  return url.includes('youtube.com/shorts/');
}

const transformShortYoutubeUrl = (url: string) => {
  const strings = url.split('youtube.com/shorts/');
  const videoValue = strings[1];

  return `https://www.youtube.com/watch?v=${videoValue}`;
};
</script>
