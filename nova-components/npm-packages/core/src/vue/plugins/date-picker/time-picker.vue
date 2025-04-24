<template>
  <div :id="inputName">
    <DatePicker
      v-model="value"
      color="blue"
      titlePosition="left"
      mode="time"
      is24hr
      :isDark
      locale="tw"
      :masks="{
        input: format,
      }"
      :popover="{ visibility: 'click' }"
    >
      <template #default="{ inputValue, inputEvents }">
        <input
          type="text"
          autocomplete="off"
          :name="inputName"
          :dusk="duskName"
          :class="classNames"
          :style="styleObj"
          :placeholder="placeholder"
          :value="inputValue"
          v-on="inputEvents"
          :disabled="readonly"
        />
      </template>
    </DatePicker>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { DatePicker } from 'v-calendar';
import 'v-calendar/style.css';

const props = defineProps({
  inputName: {
    type: String,
    default: '',
  },
  duskName: {
    type: String,
    default: '',
  },
  classNames: {
    type: Array,
  },
  isDark: {
    type: Boolean,
    default: false,
  },
  format: {
    type: String,
    default: 'HH:mm',
  },
  readonly: {
    type: Boolean,
    default: false,
  },
  placeholder: {
    type: String,
    default: '請輸入時間',
  },
  inputWidth: {
    type: Number,
    default: 0,
  },
  inputMinWidth: {
    type: Number,
    default: 0,
  },
  inputMaxWidth: {
    type: Number,
    default: 0,
  },
});

const value = defineModel();

const computeStyleObj = () => {
  return {
    width: props.inputWidth ? `${props.inputWidth}px` : '',
    inputMinWidth: props.inputMinWidth ? `${props.inputMinWidth}px` : '',
    inputMaxWidth: props.inputMaxWidth ? `${props.inputMaxWidth}px` : '',
  };
};

const styleObj = ref(computeStyleObj());

watch(
  () => [props.inputWidth, props.inputMinWidth, props.inputMaxWidth],
  () => {
    styleObj.value = computeStyleObj();
  },
  { immediate: true }
);

watch(
  () => props.value,
  (newValue) => {
    const date = new Date();
    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();
    const [hour, minute] = newValue ? newValue.split(':') : [date.getHours(), date.getMinutes()];
    value.value = new Date(`${year}-${month}-${day} ${hour}:${minute}`);
  },
  { immediate: true }
);
</script>
