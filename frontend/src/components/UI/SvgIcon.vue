<template>
  <svg
      :class="svgClass"
      :viewBox="viewBox"
      aria-hidden="true"
      role="img"
      aria-label="[svgIcon]"
      @click="$emit('click')"
  >
    <title v-if="!!title">
      {{ title }}
    </title>

    <use :href="iconName"></use>
  </svg>
</template>

<script>
export default {
  name: 'SvgIcon',
  props: {
    name: {
      type: String,
      required: true,
    },
    id: {
      type: String,
      default: '',
    },
    title: {
      type: String,
      default: '',
    },
    className: {
      type: String,
      default: '',
    },
    viewBox: {
      type: String,
      default: '0 0 16 16',
    },
  },
  computed: {
    iconName() {
      return `#${this.name}`;
    },
    svgClass() {
      const classList = ['svg-icon', `svg-icon--${this.name}`];
      if (this.className) {
        classList.push(this.className);
      }
      return classList.join(' ');
    },
  },
};
</script>

<style lang="scss">
.svg-icon {
  overflow: hidden;
  width: 1em;
  height: 1em;
  fill: currentColor;
}
</style>
