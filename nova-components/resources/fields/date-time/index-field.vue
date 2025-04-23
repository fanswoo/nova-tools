<template>
  <span>{{ fieldValue }}</span>
</template>

<script>
import moment from 'moment';
import 'moment-timezone';

export default {
  props: ['resourceName', 'field'],

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
    fieldValue() {
      if(this.field.mode === 'Time') {
        return this.field.displayedAs || this.field.value;
      }
      return moment(this.field.displayedAs || this.field.value).tz('Asia/Taipei').format(this.format);
    },
  }
}
</script>
