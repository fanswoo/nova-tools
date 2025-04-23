<template>
  <PanelItem :index="index" :field="fieldWithNewValue" />
</template>

<script>
import moment from 'moment';
import 'moment-timezone';

export default {
  props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],
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
    },
    fieldWithNewValue() {
      if(this.field.mode === 'Time') {
        return this.field;
      }

      if(!this.field.displayedAs && !this.field.value) {
        return this.field;
      }

      const fieldWithNewValue = this.field;
      fieldWithNewValue.value = moment(this.field.displayedAs || this.field.value).tz('Asia/Taipei').format(this.format);
      return fieldWithNewValue;
    },
  },
}
</script>
