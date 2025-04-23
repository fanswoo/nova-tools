<template>
  <div v-if="field.asHtml" v-html="fieldValue" :style="style"></div>
  <div v-else>{{ fieldValue }}</div>
</template>

<script>
export default {
  props: ['resourceName', 'field'],

  computed: {
    fieldValue() {
      return this.field.displayedAs || this.field.value
    },
    style() {
      return {
        width: `${this.field.width}px` || 'auto',
        'text-wrap': 'auto'
      }
    }
  },
}
</script>
