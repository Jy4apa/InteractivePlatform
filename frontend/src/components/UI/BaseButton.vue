<template>
  <button
      :type="htmlType"
      :class="classes"
      :disabled="disabled"
      @click="$emit('onClick')"
  >
    <slot name="icon_l"></slot>
    <slot>{{ label }}</slot>
    <slot name="icon_r"></slot>
  </button>
</template>

<script>

export default {
  name: 'BaseButton',
  props: {
    htmlType: {
      type: String,
      default: 'button',
      validator: (val) => ['button', 'reset', 'submit'].includes(val)
    },
    label: {
      type: String,
      default: 'Button',
    },
    type: {
      type: String,
      default: 'primary',
      validator: (val) => ['primary', 'secondary', 'standard'].includes(val)
    },
    size: {
      type: String,
      default: 'standard',
      validator: (val) => ['standard', 'small', 'full'].includes(val)
    },
    rounded: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    }

  },

  computed: {
    classes() {
      return {
        'button': true,
		'rounded': this.rounded,
        'size--standard': this.size === 'standard',
        'size--small': this.size === 'small',
        'size--full': this.size === 'full',
        'button--primary': this.type === 'primary',
        'button--secondary': this.type === 'secondary',
        'button--standard': this.type === 'standard',
        'button--disabled': this.disabled,
      };
    },
  },
};
</script>

<style lang="scss" scoped>

.button {
  @apply flex justify-center border border-transparent shadow-sm text-sm font-medium;

  cursor: pointer;
  display: block;
  outline: none;
  white-space: nowrap;
  transition: 0.4s;

  &--primary {
    @apply bg-indigo-600 text-white;

    &:hover:not(.button--disabled),
    &:active:not(.button--disabled) {
      @apply bg-indigo-700;
    }
  }

  &--secondary {
    @apply bg-gray-300;
    &:hover:not(.button--disabled),
    &:active:not(.button--disabled) {
      @apply bg-gray-200;
    }
  }

  &--standard {
    @apply bg-white;
    color: #2F80ED;

    &:hover:not(.button--disabled),
    &:active:not(.button--disabled) {
      @apply bg-white;
      color: #000;
    }
  }

  &--disabled {
    @apply bg-gray-500;
    cursor: default;
  }
}

.size {
  &--standard {
    @apply py-2 px-4;
  }
  &--small {
    @apply px-3 py-1.5;
  }
  &--full {
    @apply py-2 px-4 w-full;
  }
}

.rounded {
	@apply rounded-md;
}

</style>
