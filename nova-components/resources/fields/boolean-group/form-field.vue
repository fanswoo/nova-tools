<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <div class="checkbox-box space-y-2 flex">
        <template v-for="option in value" :key="option.name">
            <label class="flex items-center select-none space-x-2">
              <Checkbox
                :name="option.name"
                :checked="option.checked"
                @input="toggle($event, option)"
                :disabled="currentField.readonly"
              />
              <span>{{ option.label }}</span>
            </label>
        </template>
      </div>
    </template>
  </DefaultField>
</template>

<script>
import find from 'lodash/find'
import isNil from 'lodash/isNil'
import fromPairs from 'lodash/fromPairs'
import map from 'lodash/map'
import merge from 'lodash/merge'
import { DependentFormField, HandlesValidationErrors } from 'laravel-nova';

export default {
  mixins: [HandlesValidationErrors, DependentFormField],

  data: () => ({
    value: {},
  }),

  methods: {
    /*
     * Set the initial value for the field
     */
    setInitialValue() {
      let values = merge(this.finalPayload, this.currentField.value || {})

      this.value = map(this.currentField.options, o => {
        return {
          name: o.name,
          label: o.label,
          checked: values[o.name] || false,
        }
      })
    },

    /**
     * Provide a function that fills a passed FormData object with the
     * field's internal value attribute.
     */
    fill(formData) {
      this.fillIfVisible(
        formData,
        this.fieldAttribute,
        JSON.stringify(this.finalPayload)
      )
    },

    /**
     * Toggle the option's value.
     */
    toggle(event, option) {
      const firstOption = find(this.value, o => o.name == option.name)
      firstOption.checked = event.target.checked

      if (this.field) {
        this.emitFieldValueChange(
          this.fieldAttribute,
          JSON.stringify(this.finalPayload)
        )
      }
    },

    onSyncedField() {
      this.setInitialValue()
    },
  },

  computed: {
    /**
     * Return the final filtered json object
     */
    finalPayload() {
      return fromPairs(map(this.value, o => [o.name, o.checked]))
    },
  },
}
</script>

<style lang="scss" scoped>
.space-y-2>:not([hidden])~:not([hidden]) {
  margin: 0 0 5px 0;
}
.checkbox-box {
  flex-wrap: wrap;
  justify-content: flex-start;
}
label {
  flex: 1;
  width: 33%;
  min-width: 33%;
  max-width: 33%;
  margin: 0 0 5px 0;
  align-items: flex-start;
  @media (max-width: 1366px) {
    width: 50%;
    min-width: 50%;
    max-width: 50%;
  }
  @media (max-width: 400px) {
    width: 100%;
    min-width: 100%;
    max-width: 100%;
  }
}
</style>