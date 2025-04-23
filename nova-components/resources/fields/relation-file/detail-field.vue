<template>
  <PanelItem :index="index" :field="field">
    <template #value>
      <div v-if="field.value.length > 0" class="file-box">
        <template v-for="file in field.value">
          <a class="file-download" :href="file.downloadUrl" target="_blank">
            <font-awesome-icon icon="download" /> {{ file.title }}
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
$color-blue: rgba(14, 165, 233);

.file-box {
  .file-download {
    color: $color-blue;
    display: block;
    margin-bottom: 5px;
    border: 1px solid rgba(150, 150, 150, 0.5);
    float: left;
    padding: 2px 5px;
    border-radius: 5px;
  }
}
</style>