<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <div class="space-y-4">
        <div class="flex items-center">
          <button
            type="button"
            class="border text-left appearance-none cursor-pointer rounded text-sm font-bold focus:outline-none focus:ring ring-primary-200 dark:ring-gray-600 disabled:cursor-not-allowed inline-flex items-center justify-center shadow h-7 px-3 bg-primary-500 border-primary-500 hover:[&:not(:disabled)]:bg-primary-400 hover:[&:not(:disabled)]:border-primary-400 text-white dark:text-gray-900"
            @click="openRelationModal"
            :dusk="`${field.attribute}-inline-create`"
            tabindex="0"
            v-text="__('Create :resource', { resource: field.singularLabel })"
          ></button>
        </div>

        <div v-if="value.length > 0" :dusk="`${field.attribute}-selected-tags`">
          <TagList
            v-if="field.style === 'list'"
            :tags="value"
            @tag-removed="i => removeResource(i)"
            :resource-name="field.resourceName"
            :editable="!currentlyIsReadonly"
            :with-preview="field.withPreview"
          />

          <TagGroup
            v-if="field.style === 'group'"
            v-model="value"
            @tag-removed="i => removeResource(i)"
            :resource-name="field.resourceName"
            :editable="!currentlyIsReadonly"
            :with-preview="field.withPreview"
          />
        </div>
      </div>

      <CreateRelationModal
        :resource-name="field.resourceName"
        :show="relationModalOpen"
        :size="field.modalSize"
        @set-resource="handleSetResource"
        @create-cancelled="relationModalOpen = false"
      />
    </template>
  </DefaultField>
</template>

<script>
import {
  DependentFormField,
  PerformsSearches,
  HandlesValidationErrors,
  mapProps,
} from 'laravel-nova';
import first from 'lodash/first.js';
import storage from '@/storage/ResourceSearchStorage';
import TagList from '@/components/Tags/TagList.vue';
import SearchInputResult from '@/components/Inputs/SearchInputResult.vue';
import PreviewResourceModal from '@/components/Modals/PreviewResourceModal.vue';

export default {
  components: { PreviewResourceModal, SearchInputResult, TagList },
  mixins: [DependentFormField, PerformsSearches, HandlesValidationErrors],

  props: {
    ...mapProps(['resourceId']),
  },

  data: () => ({
    relationModalOpen: false,
    search: '',
    value: [],
    tags: [],
  }),

  methods: {

    fill(formData) {
      this.fillIfVisible(
        formData,
        this.currentField.attribute,
        this.value.length > 0 ? JSON.stringify(this.value) : ''
      )
    },

    fetchAvailableResources(resourceName, options) {
      return Nova.request().get(`/nova-api/${resourceName}/search`, options)
    },

    selectResource(resource) {
      const found = this.value.filter(t => t.value === resource.value)

      if (found.length === 0) {
        this.value.push(resource)
      }
    },

    handleSetResource({ id }) {
      const queryParams = {
        search: '',
        current: id,
        first: true,
      }

      storage
        .fetchAvailableResources(this.currentField.resourceName, {
          params: queryParams,
        })
        .then(({ data: { resources } }) => {
          this.selectResource(first(resources))
        })
        .finally(() => {
          this.closeRelationModal()
        })
    },

    removeResource(index) {
      this.value.splice(index, 1)
    },

    openRelationModal() {
      this.relationModalOpen = true
    },

    closeRelationModal() {
      this.relationModalOpen = false
    },
  },
}
</script>
