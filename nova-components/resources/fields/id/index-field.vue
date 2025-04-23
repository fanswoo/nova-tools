<template>
  <div :class="`text-${field.textAlign}`">
    <Link
      @click.stop
      v-if="canShowLink"
      :href="href"
      class="link-default"
    >
      {{ displayText }}
    </Link>
    <p v-else-if="fieldHasValue || isPivot">
      {{ field.pivotValue || displayText }}
    </p>
    <p v-else>&mdash;</p>
  </div>
</template>

<script>
import isNil from 'lodash/isNil';
import { FieldValue } from 'laravel-nova';

export default {
  mixins: [FieldValue],

  props: ['resource', 'resourceName', 'field'],

  computed: {
    isPivot() {
      return !isNil(this.field.pivotValue)
    },
    authorizedToView() {
      return this.resource?.authorizedToView ?? false
    },
    authorizedToUpdate() {
      return this.resource?.authorizedToUpdate ?? false
    },
    displayText() {
      return this.field.displayText || this.fieldValue;
    },
    href() {
      if(this.field.alwaysLinkToViewPage) {
        return this.$url(`/resources/${this.resourceName}/${this.field.value}`);
      }

      return this.authorizedToUpdate ? this.$url(`/resources/${this.resourceName}/${this.field.value}/edit`) : this.$url(`/resources/${this.resourceName}/${this.field.value}`);
    },
    canShowLink() {
      return this.fieldHasValue && !this.isPivot && this.authorizedToView || this.fieldHasValue && !this.isPivot && this.authorizedToUpdate
    }
  },

  mounted() {
  }
}
</script>
