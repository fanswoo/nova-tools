<template>
  <div class="pic-field">
    <img v-if="field.value[0]?.url?.w50h50" :src="field.value[0]?.url?.w50h50" alt="pic"/>
    <span v-else>—</span>
  </div>
</template>

<script>
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