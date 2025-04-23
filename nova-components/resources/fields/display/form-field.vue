<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <span v-if="currentField.asHtml" v-html="value"></span>
      <span v-else>{{ value }}</span>
    </template>
  </DefaultField>
</template>

<script>
import { FormField, DependentFormField, HandlesValidationErrors } from 'laravel-nova';

export default {
  mixins: [FormField, DependentFormField, HandlesValidationErrors],

  props: ['resourceName', 'resourceId', 'field'],

  methods: {
    setInitialValue() {
      this.value = this.currentField.value || '';
    },

    fill(formData) {
      formData.append(this.fieldAttribute, this.value || '')
    },

  },
  mounted() {
  }
}
</script>

<style scoped>
span {
  line-height: 2.4rem;
}
</style>