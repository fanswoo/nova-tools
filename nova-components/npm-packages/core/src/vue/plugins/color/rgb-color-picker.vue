<template>
  <input
    type="text"
    :name="inputName"
    class="hueb-color"
    v-bind:value="colorRgb"
    v-bind:style="getStyle()"
    v-bind:placeholder="colorRgb"
  />
</template>

<script>
import Huebee from 'huebee';
import 'huebee/dist/huebee.min.css';

export default {
  props: {
    colorRgb: {
      type: String,
      default: '#000000',
    },
    inputName: {
      type: String,
      default: 'colorRgb',
    },
    styleObject: {
      type: Object,
      default: () => ({}),
    },
  },
  data: () => {
    return {};
  },
  methods: {
    getStyle() {
      return {
        width: '100px',
        ...this.styleObject,
        background: this.colorRgb,
      };
    },
    bindHuebee() {

      $('.hueb-color:not([bind-hueb-color])').each((
        key,
        value,
      ) => {
        $(this).attr('bind-hueb-color', true);
        const hueb = new Huebee(value, {
          notation: 'hex',
          saturations: 2,
          initialColor: this.colorRgb,
        });
        hueb.on('change', function(color, hue, sat, lum) {
          this.close();
        });
      });
    },
  },
  mounted() {
    this.$nextTick(() => {
      this.bindHuebee();
    });
  },
  updated() {
    this.$nextTick(() => {
      this.bindHuebee();
    });
  },
};
</script>

<style lang="scss" scoped>
input.hueb-color {
  width: 20px;
  transition: background 1s, width 0.3s;
  &:focus,
  &:hover {
    width: 75px;
    border-color: #ccc;
  }
}
</style>