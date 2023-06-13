<template>
  <div class="datepicker">
    <span v-if="label" class="block label">
      {{ label }}
      <sup v-if="star" class="text-red-600">*</sup>
    </span>
    <div>
      <div class="control__field flex w-full relative">
        <VueDatePicker
            v-model="model"
            locale="ru"
            :auto-apply="autoApply"
            :enable-time-picker="enableTimePicker"
            format="dd.MM.yyyy"
        ></VueDatePicker>
      </div>
    </div>
  </div>
</template>

<script>
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import VModelMixin from "@/common/mixins/VModelMixin";
import SvgIcon from "@/components/UI/SvgIcon.vue";

export default {
  name: 'BaseDatepicker',
  components: {SvgIcon, VueDatePicker },
  mixins: [VModelMixin],
  props: {
    label: {
      type: String,
      default: '',
    },
    star: {
      type: Boolean,
      default: false,
    },
    autoApply: {
      type: Boolean,
      default: false,
    },
    enableTimePicker: {
      type: Boolean,
      default: false,
    },
  },
}
</script>

<style lang="scss" scoped>
.datepicker {
  .label {
    @apply text-gray-700 font-medium text-sm pb-2;
  }
}
</style>