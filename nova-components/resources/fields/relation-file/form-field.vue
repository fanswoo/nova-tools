<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <UploadFile v-model="value" />
    </template>
  </DefaultField>
</template>

<script setup lang="ts">
import UploadFile from '@fanswoo/core/vue/upload/upload-file/upload-file.vue';
import { FormField, DependentFormField, HandlesValidationErrors } from 'laravel-nova';

defineOptions({
  mixins: [FormField, DependentFormField, HandlesValidationErrors],
  methods: {
    fill(formData) {
      const fileIds = [];
      this.value.forEach((file) => {
        fileIds.push(file.id);
      });
      this.fillIfVisible(formData, this.fieldAttribute, fileIds || '');
    },
  }
});

</script>

<style scoped>
span {
  line-height: 2.2rem;
}
</style>