<template>
  <div :class="rootClasses">
    <div class="w-full relative">
      <label :for="name" class="block font-medium text-sm pb-2 label"
          v-if="label">
        {{ label }}
        <sup v-if="star" class="text-red-600">*</sup>
      </label>
      <textarea
          :name="name"
          :placeholder="placeholder"
          :value.sync="model"
          @change="change"
          @input="change"
		    @focus="$emit('onFocus')"
          class="h-40 shadow-sm block w-full text-gray-700 focus:ring-1 focus:border-none sm:text-sm border border-gray-300 rounded-md px-3 py-2"
      />
    </div>
    <p v-if="message" class="mt-2 text-sm text-red-600">
      {{ message.text || message }}
    </p>
  </div>
</template>

<script>
import VModelMixin from '@/common/mixins/VModelMixin';

export default {
  name: 'BaseTextarea',
  mixins: [VModelMixin],
  props: {
    name: {
      type: String,
      default: '',
    },
    label: {
      type: String,
      default: '',
    },
    message: {
      type: String,
      default: '',
    },
    placeholder: {
      type: String,
      default: '',
    },
    status: {
      type: String,
      default: 'info', // error, success
      validator: value => {
        return ['error', 'info', 'success'].indexOf(value) >= 0;
      },
    },
    solo: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    tabindex: {
      type: [Number, String],
      default: 0,
    },
    star: {
      type: Boolean,
      default: false,
    },
  },

  computed: {
    rootClasses() {
      const baseClass = 'control';
      const res = [baseClass];
      if (this.disabled) {
        res.push('disabled');
      }
      if (this.status) {
        res.push(`control--status-${this.status}`);
      }
      if (this.solo) {
        res.push('solo');
      }
      return res;
    },
  },
};
</script>

<style lang="scss" scoped>
.label {
  @apply text-gray-700;
}
</style>
