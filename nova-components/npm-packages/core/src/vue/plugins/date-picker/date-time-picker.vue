<template>
  <div :id="inputName">
    <DatePicker
      v-model="value"
      color="blue"
      titlePosition="left"
      mode="dateTime"
      is24hr
      :isDark
      locale="tw"
      :modelConfig="{
        type: 'string',
        mask: format,
      }"
      :masks="{
        title: 'YYYY 年 MM 月',
        inputDateTime24hr: format,
      }"
      :popover="{ visibility: 'click' }"
    >
      <template #default="{ inputValue, inputEvents }">
        <input
          type="text"
          autocomplete="off"
          :class="classNames"
          :name="inputName"
          :dusk="duskName"
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
import { ref, watch, computed } from 'vue';
import { DatePicker } from 'v-calendar';
import 'v-calendar/style.css';

interface IStyle {
  width: string;
  inputMinWidth: string;
  inputMaxWidth: string;
}

const props = defineProps({
  inputName: String,
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
    default: 'YYYY-MM-DD HH:mm',
  },
  readonly: {
    type: Boolean,
    default: false,
  },
  placeholder: {
    type: String,
    default: '請輸入日期與時間',
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

const width = computed(() => props.inputWidth);
const minWidth = computed(() => props.inputMinWidth);
const maxWidth = computed(() => props.inputMaxWidth);

const styleObj = computed(() => {
  const style: IStyle = {
    width: '',
    inputMinWidth: '',
    inputMaxWidth: '',
  };

  if (width.value === undefined || width.value == null) {
    style.width = Number.isNaN(width.value) ? width.value : `${width.value}px`;
  }

  if (minWidth.value === undefined || minWidth.value == null) {
    style.inputMinWidth = Number.isNaN(minWidth.value) ? minWidth.value : `${minWidth.value}px`;
  }

  if (maxWidth.value === undefined || maxWidth.value == null) {
    style.inputMaxWidth = Number.isNaN(maxWidth.value) ? maxWidth.value : `${maxWidth.value}px`;
  }

  return style;
});
</script>
