<template>
  <div>
    <div class="pic-upload-button">
      <span><font-awesome-icon icon="image" /> 上傳圖片</span>
      <input
        ref="uploadPicButton"
        name="files[]"
        type="file"
        accept="image/*"
        :multiple="!isSinglePic"
        @change="onUploadPics($event)"
      />
    </div>
    <span class="pic-upload-message" v-html="message"></span>
  </div>
</template>

<script lang="ts" setup>
import { onMounted, ref } from 'vue';
import { uploadPics } from '@fanswoo/core/vue/upload/upload-pic/upload-pic';

const props = defineProps({
  isSinglePic: {
    type: Boolean,
    default: false,
  },
  postMaxSize: {
    type: Number,
    default: 0,
  },
  uploadMaxSize: {
    type: Number,
    default: 0,
  },
  relatedPicName: {
    type: String,
    default: '',
  },
  defaultMessage: {
    type: String,
    default: '點擊 <kbd>CTRL</kbd> 可複選圖片',
  },
});

const {
  isSinglePic,
  postMaxSize,
  uploadMaxSize,
  relatedPicName,
} = props;

const emit = defineEmits(['showErrorMessage']);
const message = ref(props.defaultMessage);
const uploadPicButton = ref();
const pics = defineModel();

const onUploadPics = async (event) => {
  message.value = '圖片上傳...';

  const response = await uploadPics(event.target.files, {
    relatedPicName,
    postMaxSize,
    uploadMaxSize,
  });

  uploadPicButton.value = '';

  if (response.status === true) {
    pics.value.push(...response.pics);
  }

  message.value = props.defaultMessage;

  if (response.status === false) {
    emit('showErrorMessage', response.message);
  }
};
</script>

<style lang="scss" scoped>
$color-blue: rgba(14, 165, 233);
$color-white: rgba(226, 232, 240);

.pic-upload-button {
  position: relative;
  overflow: hidden;
  margin: 5px 5px 5px 0;
  display: inline-block;
  padding: 0;
  color: $color-white;
  text-align: center;
  vertical-align: middle;
  background: $color-blue;
  font-weight: 700;
  border-radius: 4px;
  cursor: pointer;
  & > span {
    display: block;
    border-radius: 4px;
    padding: 0 10px;
    height: 28px;
    line-height: 30px;
    cursor: pointer;
    font-size: 12px;
  }
  input {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    border: solid transparent;
    opacity: 0;
    filter: alpha(opacity=0);
    cursor: pointer;
    animation: none;
    transition: none;
    line-height: 30px;
    height: 30px;
  }
  .pic-upload-message {
    color: #777;
    height: 20px;
    line-height: 20px;
  }
}
</style>
