<template>
  <div :class="`text-${field.textAlign}`">
    <template v-if="fieldHasValue">
      <div v-if="shouldDisplayAsHtml" @click.stop v-html="fieldValue"></div>
      <span v-else class="whitespace-nowrap">
        <a
          class="link-default"
          :href="field.value"
          rel="noreferrer noopener"
          :target="this.field.newWindow ? '_blank' : '_self'"
          @click.stop
        >
          {{ fieldValue }}
        </a>
      </span>
    </template>
    <p v-else>&mdash;</p>
  </div>
</template>

<script>
import { FieldValue } from 'laravel-nova';

export default {
  mixins: [FieldValue],

  props: ['resourceName', 'field'],
}
</script>
