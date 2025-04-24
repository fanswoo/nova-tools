<template>
  <span>
    <button
      ref="imageButton"
      type="button"
      :class="{ 'is-active': editor.isActive('underline') }"
      @click="addImage"
    >
      <FontAwesomeIcon icon="image" />
    </button>
    <input
      ref="uploadPicButton"
      style="display: none"
      name="files[]"
      type="file"
      accept="image/*"
      multiple
      @change="onUploadPics"
    />
    <input
      v-for="picId in picIds"
      type="hidden"
      :name="inputNamePic + '[]'"
      :value="picId"
    />
  </span>
</template>

<script lang="ts" setup>
import { ref, onMounted, inject, watch } from 'vue';
import tippy from 'tippy.js';
import { uploadPics } from '@fanswoo/core/vue/upload/upload-pic/upload-pic';

defineOptions({
  name: 'ImageButton',
});

const { inputNamePic } = defineProps({
  inputNamePic: {
    type: String,
    default: '',
  },
});

const emit = defineEmits(['onPicIdsChange']);
const editor: any = inject('editor');
const imageButton = ref(null);
const uploadPicButton = ref();
const picIds = ref<number[]>([]);

const onUploadPics = async (event) => {
  const response = await uploadPics(event.target.files);

  if (!response) {
    return;
  }

  uploadPicButton.value.value = '';

  const insertContent = [];
  response.pics.forEach((pic) => {
    const url = pic.url.w0h0;
    insertContent.push({
      type: 'image',
      attrs: {
        src: url,
      },
    });
  });

  editor.value.chain().focus().insertContent(insertContent).run();

};

const addImage = async () => {
  uploadPicButton.value.click();
};

const onUpdatePicIds = () => {
  const newPicIds: number[] = [];
  const imgUrls: (string | null)[] = Array.from(
    new DOMParser()
      .parseFromString(editor.value.getHTML(), 'text/html')
      .querySelectorAll('img'),
  ).map((img) => img.getAttribute('src'));

  for (let i: number = 0; i < imgUrls.length; i += 1) {
    if (!imgUrls[i]) {
      continue;
    }

    const ImgURL: {
      pathname: string;
    } = new URL(imgUrls[i]!);

    if (ImgURL.pathname) {
      const ImgURLLink = ImgURL.pathname.split('/pic/')[1];
      if (ImgURLLink) {
        const ImgURLTmp: string[] = ImgURLLink.split('-');
        const id: number = parseInt(ImgURLTmp[0].replace(/\//g, ''), 10);
        const md5: string = ImgURLTmp[1].split('.')[0];
        newPicIds.push(id);
      }
    }
  }

  picIds.value = newPicIds;
};

editor.value.on('create', () => {
  onUpdatePicIds();
});

editor.value.on('update', () => {
  onUpdatePicIds();
});

watch(() => picIds.value, () => {
  emit('onPicIdsChange', picIds.value);
});

onMounted(() => {
  tippy(imageButton.value, {
    content: '插入圖片',
    theme: 'tooltip',
  });
});
</script>
