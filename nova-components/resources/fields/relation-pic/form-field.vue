<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <UploadPic
        v-model="value"
        @showErrorMessage="errorMessage = $event"
        :postMaxSize="currentField.postMaxSize"
        :uploadMaxSize="currentField.uploadMaxSize"
        :relatedPicName="currentField.relatedPicName"
      />
      <p class="help-text help-text-error" v-text="errorMessage"></p>
    </template>
  </DefaultField>
</template>

<script setup lang="ts">
import UploadPic from '@fanswoo/core/vue/upload/upload-pic/upload-pic.vue';
import { FormField, DependentFormField, HandlesValidationErrors } from 'laravel-nova';
import { watch } from "vue";

defineOptions({
  mixins: [FormField, DependentFormField, HandlesValidationErrors],
  methods: {
    fill(formData) {
      this.fillIfVisible(formData, this.fieldAttribute, JSON.stringify(this.value));
    },
  },
  data: () => ({
    errorMessage: '',
  }),
  watch: {
    value: {
      handler(newValue) {
        this.value = newValue;

        if (this.field) {
          this.emitFieldValueChange(this.fieldAttribute, this.value);
          this.$emit('field-changed');
        }
      },
      deep: true
    }
  },
});

</script>

<style scoped>
span {
  line-height: 2.2rem;
}
</style>