<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <DateTimePicker
        v-if="field.mode === 'DateTime'"
        :duskName="field.attribute"
        :classNames="['form-control', 'form-control-bordered', 'form-input']"
        v-model="value"
        timezone="Asia/Taipei"
        :isDark
        :readonly="currentlyIsReadonly"
      />
      <DatePicker
        v-if="field.mode === 'Date'"
        :duskName="field.attribute"
        :classNames="['form-control', 'form-control-bordered', 'form-input']"
        v-model="value"
        timezone="Asia/Taipei"
        :isDark
        :readonly="currentlyIsReadonly"
      />
      <TimePicker
        v-if="field.mode === 'Time'"
        :duskName="field.attribute"
        :classNames="['form-control', 'form-control-bordered', 'form-input']"
        v-model="value"
        timezone="Asia/Taipei"
        :isDark
        :readonly="currentlyIsReadonly"
      />
      <YearMonthPicker
        v-if="field.mode === 'YearMonth'"
        :duskName="field.attribute"
        :classNames="['form-control', 'form-control-bordered', 'form-input']"
        v-model="value"
        timezone="Asia/Taipei"
        :isDark
        :readonly="currentlyIsReadonly"
      />
    </template>
  </DefaultField>
</template>

<script>
import DateTimePicker from '@fanswoo/core/vue/plugins/date-picker/date-time-picker.vue';
import DatePicker from '@fanswoo/core/vue/plugins/date-picker/date-picker.vue';
import TimePicker from '@fanswoo/core/vue/plugins/date-picker/time-picker.vue';
import YearMonthPicker from '@fanswoo/core/vue/plugins/date-picker/year-month-picker.vue';
import { DependentFormField, HandlesValidationErrors } from 'laravel-nova';
import moment from 'moment';
import 'moment-timezone';

export default {
  components: { DateTimePicker, DatePicker, TimePicker, YearMonthPicker },
  mixins: [DependentFormField, HandlesValidationErrors],
  data() {
    return {
      isDark: false,
    };
  },
  props: ['resourceName', 'resourceId', 'field'],
  computed: {
    format() {
      switch(this.field.mode) {
        case 'DateTime':
          return 'YYYY-MM-DD HH:mm';
        case 'Date':
          return 'YYYY-MM-DD';
        case 'Time':
          return 'HH:mm';
        case 'YearMonth':
          return 'YYYY-MM';
      }
    }
  },
  methods: {
    setInitialValue() {
      this.changeValue();
    },
    onSyncedField() {
      this.changeValue();
    },
    changeValue() {
      if(this.currentField.mode === 'Time' || !this.currentField.value) {
        this.value = this.currentField.value;
        return;
      }
      this.value = moment(this.currentField.value).tz('Asia/Taipei').format(this.format);
    },
    fill(formData) {
      const value = this.value ? moment(this.value).tz('Asia/Taipei').format(this.format) : '';
      formData.append(this.fieldAttribute, value);
    },
  },
  mounted() {
    this.isDark = document.documentElement.classList.contains('dark');
  }
}
</script>

<style scoped>
span {
  line-height: 2.4rem;
}
</style>