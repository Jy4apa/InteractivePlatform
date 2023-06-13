<template>
  <div>
    <span
        v-if="selectLabel"
        class="block font-medium text-sm pb-2 label"
    >
      {{ selectLabel }}
      <sup v-if="star" class="text-red-600">*</sup>
    </span>
    <div :class="rootClasses">
      <multiselect
          ref="multiselect"
          :name="name"
          :class="multiselectClasses"
          :options="options"
          class="relative z-6 ui__select"
          :disabled="disabled"
          :taggable="taggable"
          :searchable="searchable"
          :track-by="trackBy"
          :message="message"
		      :model-value="model"
          :close-on-select="closeOnSelect"
          :label="label"
          :multiple="multiple"
          :placeholder="placeholder"
          :loading="loading"
          :clear-on-select="clearOnSelect"
          :internal-search="internalSearch"
          :group-select="groupSelect"
          :group-values="groupValues"
          :group-label="groupLabel"
          :hide-selected="hideSelected"
          :preserveSearch="preserveSearch"
          :openDirection="openDirection"
          @tag="onTag"
          @select="onChange"
          @close="onClose"
          @remove="onRemove"
          @search-change="onSearchChange"
          @open="onOpen"
      >
        <template v-slot:noOptions>Список пуст</template>
        <template v-slot:noResult>Не найдено</template>
        <template slot="maxElements">
          Выбрано допустимое количество.
        </template>
        <template slot="option" slot-scope="props">
          <div v-if="!multiple" class="option-desc">
            <!-- this.icon -->
            <div v-if="iconLeft" class="select-icon select-left">
              <i :class="iconLeft"></i>
            </div>
            {{ props.option[label] || props.option.$groupLabel || props.option }}
          </div>
        </template>
        <template slot="caret">
          <svg-icon
              v-if="model && clearable"
              class="cursor-pointer multiselect__select"
              name="icon-cross"
              @click="onClear"
          />
          <svg-icon v-else
                    class="hidden"
                    name="arrow_select"
          />
        </template>
        <template slot="clear">
          <div>1</div>
        </template>
        <span
            class="checkbox-label"
            slot="option"
            slot-scope="scope"
        >
          <div v-if="multiple">
            <div class="select-option__content">
              {{ scope.option.name }}
            </div>
          </div>
          <span v-else>{{ scope.option[label] || scope.option.name || scope.option }}</span>
        </span>
      </multiselect>
      <span
          v-if="message"
          class="help-text absolute">
        {{ message.text || message }}
      </span>
    </div>
  </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
import VModelMixin from '@/common/mixins/VModelMixin';
import SvgIcon from '@/components/UI/SvgIcon.vue';

// Icons
import '@/assets/icons/SVG/arrow_select.svg'
import '@/assets/icons/SVG/close.svg'

export default {
  name: 'BaseSelect',
  components: {
    SvgIcon,
    Multiselect,
  },
  mixins: [VModelMixin],
  props: {
    name: {
      type: String,
      default: '',
    },
    options: {
      type: Array,
      required: true,
    },
    multiple: {
      type: Boolean,
      default: false,
    },
    message: {
      type: String,
      default: '',
    },
    selectLabel: {
      type: String,
      default: '',
    },
    closeOnSelect: {
      type: Boolean,
      default: true,
    },
    label: {
      type: String,
      default: '',
    },
    star: {
      type: Boolean,
      default: false,
    },
    preserveSearch: {
      type: Boolean,
      default: false,
    },
    required: {
      type: Boolean,
      default: false,
    },
    taggable: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
    searchable: {
      type: Boolean,
      default: true,
    },
    loading: {
      type: Boolean,
      default: false,
    },
    internalSearch: {
      type: Boolean,
      default: true,
    },
    clearOnSelect: {
      type: Boolean,
      default: true,
    },
    trackBy: {
      type: String,
      default: '',
    },
    groupLabel: {
      type: String,
      default: '',
    },
    groupValues: {
      type: String,
      default: '',
    },
    placeholder: {
      type: String,
      default: '',
    },
    groupSelect: {
      type: Boolean,
      default: false,
    },
    iconLeft: {
      type: String,
      default: '',
    },
    openDirection: {
      type: String,
      default: '',
    },
    hideSelected: {
      type: Boolean,
      default: false,
    },
    status: {
      type: String,
      default: 'info', // error, success
      validator: value => {
        return ['error', 'success', 'info'].indexOf(value) >= 0;
      },
    },
    clearable: {
      type: Boolean,
      default: false,
    }
  },
  computed: {
    rootClasses() {
      const baseClass = 'custom-select';
      const res = [baseClass];
      if (this.required) {
        res.push('required');
      }
      if (this.disabled) {
        res.push('disabled');
      }
      if (this.status) {
        res.push(`is-status-${this.status}`);
      }
      if (this.iconLeft) {
        res.push('has-icon-left');
      }
      return res;
    },
    multiselectClasses() {
      const baseClass = 'ui-select';
      const res = [baseClass];
      if (this.iconLeft) {
        res.push('has-icon-left');
      }
      return res;
    },
  },
  methods: {
    onSelect(event) {
      this.$emit('onSelect', event);
    },
    onTag(event) {
      this.$emit('tag', event);
    },
    onChange(event) {
      if (!this.multiple) {
        this.change(event);
      } else {
        this.model.push(event);
        this.$emit('update:modelValue', this.model);
      }
      this.$emit('onChange', event);
    },
    onClose(event) {
      this.$emit('close', event);
    },
    onRemove(event) {
      if (this.multiple) {
        const index = this.model.indexOf(event);
        this.model.splice(index, 1);
      }
      this.$emit('onRemove', event);
    },
    onSearchChange(event) {
      this.$emit('searchChange', event);
    },
    onClear() {
      this.$emit('update:modelValue', null)
    },
    onOpen() {
      this.$emit('onOpen')
    },
  },
};
</script>

<style lang="scss" scoped>
@import '../../assets/styles/config/variables';

.custom-select {
	@apply w-full relative;
	& + .custom-select {
		margin-left: 1rem;
	}
	
	.control__label {
		.select-label {
			position: absolute;
			left: 13px;
			top: 15px;
			font-size: 14px;
			color: $color-grey;
			transition: all 0.2s ease;
		}
		.select-label--active {
			outline: 0;
			top: 0;
			font-size: 12px;
		}
		
		.icon {
			color: $color-primary;
		}
	}
	.help-text {
		font-size: 14px;
		color: $color-error;
	}
	
	:deep(.multiselect__input) {
		font-size: 14px;
		outline: none;
		box-shadow: none;
	
	}
	:deep(.multiselect__tags) {
		min-height: 38px;
    height: 38px;
    @apply text-sm border border-gray-300 rounded-md py-2 px-3 placeholder-gray-500;
	}
	:deep(.multiselect__option--highlight) {
		background: $background-blue;
		color: $color-black
	}
	
	:deep(.multiselect__option) {
		font-size: 0.875rem;
		&:after {
		display: none;
		}
	}
	:deep(.multiselect__single) {
		font-size: 0.875rem;
		margin-bottom: 0;
    padding-left: 0;
    color: black;
	}
	.multiselect--disabled {
		@apply select-none pointer-events-none opacity-60;
		background: none;
	}
	.select-option__content {
		display: flex;
	}
	.select__label {
		font-size: 14rem;
		line-height: 1.4rem;
		margin: 0.5rem 0;
		font-weight: 600;
		
		.required {
			color: #2f80ed;
			line-height: 1rem;
		}
	}
	
	.select-message {
		font-size: 0.7rem;
		line-height: 1.15rem;
		color: gray;
		margin-bottom: 5px;
	}
	
	&.is-status-error {
		:deep(.multiselect__tags) {
			border-color: $color-error;
		}
		
		:deep(.select-message),
		.select {
			border-color: $color-error;
			color: $color-error;
		}
	}
	:deep(.checkbox) {
		margin-top: 0;
	}
}
.label {
  @apply text-gray-700;
}
.solo {
	input:-webkit-autofill {
		-webkit-box-shadow: 0 0 0 1000px $background-white inset;
	}
}
</style>
