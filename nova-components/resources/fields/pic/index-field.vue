<template>
  <div class="pic-field">
    <img v-if="field.value" :src="field.value" alt="pic"/>
    <span v-else>—</span>
  </div>
</template>

<script>
import isNil from 'lodash/isNil';
import { FieldValue } from 'laravel-nova';

export default {
  mixins: [FieldValue],

  props: ['resource', 'resourceName', 'field'],
}
</script>

<style lang="scss" scoped>
.pic-field {
  width: 50px;
  height: 50px;
  img {
    width: 50px;
    height: 50px;
  }
}
</style>