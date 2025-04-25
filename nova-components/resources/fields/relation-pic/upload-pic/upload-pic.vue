<template>
  <div>
    <UploadButton
      v-if="
        (!hideUploadButton && !isSinglePic) || !pics || (isSinglePic && pics.length === 0)
      "
      :postMaxSize="postMaxSize"
      :uploadMaxSize="uploadMaxSize"
      :defaultMessage="defaultMessage"
      :relatedPicName="relatedPicName"
      v-model="pics"
      @showErrorMessage="showErrorMessage"
      :isSinglePic="isSinglePic"
    />
    <UploadList v-model="pics" />
  </div>
</template>

<script setup lang="ts">
import { ref, watch, onMounted } from 'vue';
import UploadButton from './upload-button.vue';
import UploadList from './upload-list.vue';

const props = defineProps({
  isSinglePic: {
    type: Boolean,
    default: false,
  },
  hideUploadButton: {
    type: Boolean,
    default: false,
  },
  relatedPicName: {
    type: String,
    default: '',
  },
  postMaxSize: {
    type: Number,
    default: 0,
  },
  uploadMaxSize: {
    type: Number,
    default: 0,
  },
  defaultMessage: {
    type: String,
    default: '',
  },
});

const pics = defineModel<any>();
const emit = defineEmits(['update:modelValue', 'showErrorMessage']);
watch(pics.value, (newVal) => {
  emit('update:modelValue', newVal);
}, { deep: true });
const showErrorMessage = (event) => {
  emit('showErrorMessage', event);
}
</script>