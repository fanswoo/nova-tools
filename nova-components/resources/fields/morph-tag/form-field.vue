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
          <ComboBoxInput
            ref="searchable"
            v-model="value"
            @input="performSearch"
            :error="hasError"
            :debounce="field.debounce"
            :options="tags"
            placeholder="Search"
            :autocomplete="currentField.autocomplete"
            trackBy="value"
            :disabled="currentlyIsReadonly"
            :loading="loading"
            class="w-full"
            :dusk="`${field.resourceName}-search-input`"
          >
            <template #option="{ dusk, selected, option }">
              <SearchInputResult
                :option="option"
                :selected="selected"
                :with-subtitles="field.withSubtitles"
                :dusk="dusk"
              />
            </template>
          </ComboBoxInput>

          <Button
            v-if="field.showCreateRelationButton"
            v-tooltip="
              __('Create :resource', { resource: field.singularLabel })
            "
            variant="link"
            size="small"
            leading-icon="plus-circle"
            @click="openRelationModal"
            :dusk="`${field.attribute}-inline-create`"
            tabindex="0"
          />
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
            :tags="value"
            @tag-removed="i => removeResource(i)"
            :resource-name="field.resourceName"
            :editable="!currentlyIsReadonly"
            :with-preview="field.withPreview"
          />
        </div>
      </div>

      <CreateRelationModal
        :resource-name="field.resourceName"
        :show="field.showCreateRelationButton && relationModalOpen"
        :size="field.modalSize"
        @set-resource="handleSetResource"
        @create-cancelled="relationModalOpen = false"
      />
    </template>
  </DefaultField>
</template>

<script>
import { Button } from 'laravel-nova-ui'
import storage from '@/storage/PivotableFieldStorage'
import searchStorage from '@/storage/ResourceSearchStorage'
import TagList from '@/components/Tags/TagList.vue';
import SearchInputResult from '@/components/Inputs/SearchInputResult.vue';
import PreviewResourceModal from '@/components/Modals/PreviewResourceModal.vue';
import {
  DependentFormField,
  PerformsSearches,
  HandlesValidationErrors,
  mapProps,
} from '@/mixins'
import { minimum } from '@/util'
import first from 'lodash/first'

export default {
  components: {
    Button,
    PreviewResourceModal,
    SearchInputResult,
    TagList,
  },

  mixins: [DependentFormField, PerformsSearches, HandlesValidationErrors],

  props: {
    ...mapProps(['resourceId']),
  },

  data: () => ({
    relationModalOpen: false,
    search: '',
    value: [],
    tags: [],
    loading: false,
  }),

  mounted() {
    if (this.currentField.preload) {
      this.getAvailableResources()
    }
  },

  methods: {
    /**
     * Perform a search to get the relatable resources.
     */
    performSearch(search) {
      this.search = search

      const trimmedSearch = search.trim()

      // If the field is set to preload and the user clears the search we
      // should reset the field to default and load all of the search results.
      this.searchDebouncer(() => {
        this.getAvailableResources(trimmedSearch)
      }, 500)
    },

    fetchAvailableResources(resourceName, options) {
      return Nova.request().get(`/nova-api/${resourceName}/morph-tag-search`, options)
    },

    fill(formData) {
      this.fillIfVisible(
        formData,
        this.currentField.attribute,
        this.value.length > 0 ? JSON.stringify(this.value) : ''
      )
    },

    /**
     * Get all of the available resources for the current search / trashed state.
     */
    getAvailableResources(search = '') {
      this.loading = true;
      const currentValue = this.value.map(v => v.value);

      const queryParams = {
        search: search,
        current: null,
        first: false,
        currentValue,
        allowDuplicateRelations: this.field.allowDuplicateRelations,
        withTrashed: false,
      }

      return minimum(
        this
          .fetchAvailableResources(
            this.currentField.resourceName,
            {
              params: {
                ...queryParams,
                component: this.currentField.component,
                viaRelationship: this.currentField.attribute,
              },
            }
          )
          .then(({ data: { resources } }) => {
            this.tags = resources
          })
          .finally(() => {
            this.loading = false
          }),
        250
      )
    },

    handleSetResource({ id }) {
      const queryParams = {
        search: '',
        current: id,
        first: true,
      }

      searchStorage
        .fetchAvailableResources(this.currentField.resourceName, {
          params: queryParams,
        })
        .then(({ data: { resources } }) => {
          this.$refs.searchable.choose(first(resources))
        })
        .finally(() => {
          this.closeRelationModal()
        })
    },

    removeResource(index) {
      this.$refs.searchable.remove(index)
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
