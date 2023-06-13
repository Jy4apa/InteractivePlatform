<template>
	<div class="">
    <span v-if="label" class="block font-medium text-sm pb-2 label">
      {{ label }}
      <sup v-if="star" class="text-red-600">*</sup>
    </span>
		<div :class="rootClasses">
			<div class="control__field flex w-full relative">
				<div
					v-if="iconLeft || $slots.iconLeft"
					class="control__icon control__icon--left flex items-center justify-center"
				>
					<slot name="iconLeft">
						<svg-icon class="icon icon-left mr-0" :name="iconLeft"></svg-icon>
					</slot>
				</div>
				<input
					ref="input"
					:name="name"
					:class="inputClasses"
					:type="type"
					:disabled="disabled"
					:placeholder="placeholder"
					:value="model"
					:tabindex="tabindex"
					:maxlength="maxlength"
					:max="max"
					:min="min"
					autocomplete="on"
					:readonly="readonly"
					@change="change"
					@input="change"
					@blur="$emit('onBlur', $event)"
					@keyup.enter="$emit('keyUpEnter', $event)"
					@paste="$emit('onPaste', $event)"
					@focus="$emit('onFocus')"
				/>
				<small
					v-if="innerLabel"
					class="control__label absolute"
					:class="{ 'control__label--active': !!model }"
				>
					{{ innerLabel }}
				</small>
				<div
					v-if="iconRight || $slots.iconRight"
					class="control__icon control__icon--right flex items-center justify-center"
				>
					<slot name="iconRight">
						<svg-icon class="icon icon-right" :name="iconRight"></svg-icon>
					</slot>
				</div>
				<div
					v-if="clearable && model"
					class="control__icon control__icon--right flex items-center justify-center clearable"
				>
					<svg-icon
						class="cursor-pointer control__clearable"
						name="cross"
						@click="onClear"
					/>
				</div>
			</div>
			<small v-if="message" class="control__message">
				{{ message.text || message }}
			</small>
		</div>
	</div>
</template>

<script>

import VModelMixin from "@/common/mixins/VModelMixin";
import SvgIcon from "@/components/UI/SvgIcon.vue";

export default {
	name: 'BaseInput',
	components: {
		SvgIcon
	},
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
		innerLabel: {
			type: String,
			default: '',
		},
		message: {
			type: [Object, String],
			default: '',
		},
		placeholder: {
			type: String,
			default: '',
		},
		name: {
			type: String,
			default: '',
		},
		status: {
			type: String,
			default: 'info', // error, success
			validator: (value) => {
				return ['error', 'info', 'success'].includes(value)
			},
		},
		type: {
			type: String,
			default: 'text',
			validator: (value) => {
				const result = ['text', 'number', 'date', 'tel'].includes(value)
				if (!result) {
					return value
				}
				return true
			},
		},
		iconLeft: {
			type: String,
			default: '',
		},
		iconRight: {
			type: String,
			default: '',
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
		clearable: {
			type: Boolean,
			default: false,
		},
		readonly: {
			type: Boolean,
			default: false,
		},
		maxlength: {
			type: String,
			default: '',
		},
		max: {
			type: Number,
			default: undefined,
		},
		min: {
			type: Number,
			default: undefined,
		},
	},
	computed: {
		rootClasses() {
			const baseClass = 'control'
			const res = [baseClass]
			if (this.disabled) {
				res.push('disabled')
			}
			if (this.status) {
				res.push(`control--status-${this.status}`)
			}
			if (this.iconLeft || this.$slots.iconLeft) {
				res.push('has-icon-left')
			}
			if (this.iconRight || this.$slots.iconRight) {
				res.push('has-icon-right')
			}
			if (this.solo) {
				res.push('solo')
			}
			return res
		},
		inputClasses() {
			const baseClass = 'input'
			const res = [baseClass]
			res.push('jumbotron__input')
			if (this.iconLeft || this.$slots.iconLeft) {
				res.push('has-icon-left')
			}
			if (this.iconRight || this.$slots.iconRight) {
				res.push('has-icon-right')
			}
			return res
		},
	},
	methods: {
		onClear() {
			this.$emit('input', '')
		},
	},
}
</script>

<style lang="scss" scoped>
@import '../../assets/styles/config/variables';

.control {
	@apply flex flex-col relative w-full;
	display: inline-block;
	position: relative;
	color: $color-black-default;
	border-radius: 4px;
	
	.control__icon {
		padding: 0.35rem;
		border: 1px solid transparent;
		color: currentColor;
		
		&--left {
			border-right: 0;
			border-radius: 4px 0 0 4px;
		}
		
		&--right {
			border-radius: 0 4px 4px 0;
			border-left: 0;
		}
		
		.svg-icon {
			font-size: 1.15rem;
			
			&--eye {
				opacity: 0.5;
			}
			
			&:active {
				opacity: 0.7;
			}
		}
	}
	
	.control__field {
		.input {
			@apply text-sm border border-gray-300 rounded-md py-2 px-3 placeholder-gray-500;
			flex: 1 0;
			width: 100%;
			box-shadow: none;
			
			&:focus {
				outline: 0;
				
				+ .control__label {
					top: 0;
					font-size: 0.75rem;
				}
			}
			
			&.has-icon-left {
				border-top-left-radius: 0;
				border-bottom-left-radius: 0;
				padding-left: 0;
				border-left: 0;
				
				& + .control__label {
					left: 2rem;
				}
			}
			
			&.has-icon-right {
				border-top-right-radius: 0;
				border-bottom-right-radius: 0;
				padding-right: 0;
				border-right: 0;
			}
		}
		
		input::-webkit-input-placeholder {
			color: $color-grey;
		}
		
		input::-moz-placeholder {
			color: $color-grey;
		}
		
		.control__label {
			left: 0.75rem;
			top: 0.75rem;
			font-size: 0.875rem;
			color: $color-grey;
			pointer-events: none;
			transition: all 0.2s ease;
		}
		
		.control__label--active {
			outline: 0;
			top: 0;
			font-size: 0.75rem;
		}
		
		.clearable {
			padding: 4px 8px !important;
			cursor: pointer;
			
			.control__clearable {
				font-size: 0.875rem;
			}
		}
	}
	
	.control__message {
		@apply text-sm absolute left-0 whitespace-nowrap overflow-ellipsis overflow-hidden;
		color: $color-grey;
		max-width: 100%;
	}
	
	&.has-icon-left {
		.control__message {
			left: 2.75rem;
		}
	}
	
	&--status-error {
		color: $color-error;
		border: 1px solid $color-error;
		
		.control__message,
		.control__field .control__label {
			color: $color-error;
		}
	}
	
	&.solo {
		background: $background-white;
		
		.input {
			background: $background-white;
		}
		
		.control__icon {
			&--left {
				background-color: $background-white;
			}
			
			&--right {
				background-color: $background-white;
			}
		}
	}
	
	&.disabled {
		.input {
			color: $color-black-default;
      @apply cursor-not-allowed;
		}
	}

	& + .control {
		margin-top: 1.25rem;
	}
}

.label {
  @apply text-gray-700;
}

input:-webkit-autofill {
	-webkit-box-shadow: 0 0 0 1000px $background-section inset;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
	-webkit-appearance: none;
	margin: 0;
}

/* Firefox */
input[type='number'] {
	-moz-appearance: textfield;
}

.solo {
	input:-webkit-autofill {
		-webkit-box-shadow: 0 0 0px 1000px $background-white inset;
	}
}
</style>
