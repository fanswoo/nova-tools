<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <HtmlEditorSimple
        v-if="currentField.mode === 'simple'"
        v-model="value"
        :inputName="currentField.attribute"
        minHeight="300"
        menuStickyTop="50"
      />
      <HtmlEditorClassic
        v-else-if="currentField.mode === 'classic'"
        v-model="value"
        :inputName="currentField.attribute"
        @onPicIdsChange="picIds = $event"
        minHeight="300"
        menuStickyTop="50"
      />
      <HtmlEditorPro
        v-else-if="currentField.mode === 'pro'"
        v-model="value"
        :inputName="currentField.attribute"
        @onPicIdsChange="picIds = $event"
        minHeight="300"
        menuStickyTop="50"
      />
    </template>
  </DefaultField>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { FormField, DependentFormField, HandlesValidationErrors } from 'laravel-nova';
import { HtmlEditorSimple, HtmlEditorClassic, HtmlEditorPro } from '@fanswoo/html-editor/main';

defineOptions({
  mixins: [FormField, DependentFormField, HandlesValidationErrors],
  data() {
    picIds: []
  },
  methods: {
    fill(formData) {
      this.fillIfVisible(formData, this.fieldAttribute, JSON.stringify({
        content: this.value,
        picIds: this.picIds
      }) || '');
    }
  }
})
;

const props = defineProps({
  resourceName: String,
  resourceId: String,
  field: Object,
});

onMounted(() => {
});
</script>

<style scoped>
span {
  line-height: 2.2rem;
}
</style>