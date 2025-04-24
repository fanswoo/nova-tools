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
import { ref, watch, computed } from 'vue';
import { DatePicker } from 'v-calendar';
import 'v-calendar/style.css';

interface IStyle {
  width: string;
  inputMinWidth: string;
  inputMaxWidth: string;
}

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
    default: 'YYYY-MM',
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

const styleObj = computed<IStyle>(() => {
  const style: IStyle = {
    width: props.inputWidth ? `${props.inputWidth}px` : '',
    inputMinWidth: props.inputMinWidth ? `${props.inputMinWidth}px` : '',
    inputMaxWidth: props.inputMaxWidth ? `${props.inputMaxWidth}px` : '',
  };

  return style;
});
</script>
