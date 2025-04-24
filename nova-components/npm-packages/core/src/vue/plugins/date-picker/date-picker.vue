<template>
  <div :id="inputName">
    <DatePicker
      v-model="value"
      color="blue"
      titlePosition="left"
      :isDark
      locale="tw"
      :masks="{
        title: 'YYYY 年 MM 月',
        input: format,
      }"
      :popover="{ visibility: 'click' }"
    >
      <template #default="{ inputValue, inputEvents }">
        <input
          type="text"
          :name="inputName"
          :dusk="duskName"
          :style="styleObj"
          :class="classNames"
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
import { ref, computed, watch, onMounted } from 'vue';
import { DatePicker } from 'v-calendar';
import 'v-calendar/style.css';

// Define props
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
    default: 'YYYY-MM-DD',
  },
  readonly: {
    type: Boolean,
    default: false,
  },
  placeholder: {
    type: String,
    default: '請輸入日期',
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

// Computed properties for styles
const styleObj = computed(() => {
  const width = props.inputWidth ? `${props.inputWidth}px` : '';
  const inputMinWidth = props.inputMinWidth ? `${props.inputMinWidth}px` : '';
  const inputMaxWidth = props.inputMaxWidth ? `${props.inputMaxWidth}px` : '';

  return {
    width,
    inputMinWidth,
    inputMaxWidth,
  };
});
</script>
