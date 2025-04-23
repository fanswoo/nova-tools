<template>
  <PanelItem :index="index" :field="field">
    <template #value>
      <div v-if="field.value.length > 0" class="pic-field">
        <template v-for="pic in field.value">
          <a :href="pic.url.w0h0" target="_blank">
            <img :src="pic.url.w50h50" alt="pic"/>
          </a>
        </template>
      </div>
      <span v-else>—</span>
    </template>
  </PanelItem>
</template>

<script setup>
const props = defineProps(['index', 'resource', 'resourceName', 'resourceId', 'field']);
</script>

<style lang="scss" scoped>
.pic-field {
  a {
    display: block;
    float: left;
    margin-right: 2px;
    margin-bottom: 2px;
    img {
      width: 50px;
      height: 50px;
    }
  }
}
</style>