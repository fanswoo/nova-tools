<template>
  <div :class="fieldWrapperClasses">
    <div :class="labelClasses">
      <label :class="labelFieldClasses">
        <span v-text="name"></span>
      </label>
    </div>
    <div :class="controlWrapperClasses">
      <slot />
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
  name: string;
  fullWidth?: boolean;
}>();

const fieldWrapperClasses = computed(() => {
  return [
    'space-y-2',
    'md:flex',
    '@md/modal:flex',
    'md:flex-row',
    '@md/modal:flex-row',
    'md:space-y-0',
    '@md/modal:space-y-0',
    'py-5'
  ]
});

const labelClasses = computed(() => {
  return [
    'w-full',
    'px-6',
    'md:mt-2',
    '@md/modal:mt-2',
    'md:px-8',
    '@md/modal:px-8',
    'md:w-1/5',
    '@md/modal:w-1/5',
  ]
});

const labelFieldClasses = computed(() => {
  return [
    'inline-block',
    'leading-tight',
    'space-x-1'
  ];
});

const controlWrapperClasses = computed(() => {
  return [
    'w-full',
    'space-y-2',
    'px-6',
    'md:px-8',
    '@md/modal:px-8',
    !props.fullWidth && 'md:w-3/5 @md/modal:w-3/5',
    props.fullWidth && 'md:w-4/5 @md/modal:w-4/5'
  ];
});
</script>

<style scoped lang="scss">

</style>