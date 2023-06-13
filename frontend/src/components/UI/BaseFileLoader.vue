<template>
	<div class="file-loader">
		<div class="control ">
			<slot>
				<div :id="id"></div>
			</slot>
		</div>
	</div>
	
</template>

<script>
import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import Russian from '@uppy/locales/lib/ru_RU';
import Url from '@uppy/url';

export default {
	name:    'BaseFileLoader',
	props:   {
		id:          {
			type:    String,
			default: 'file',
		},
		autoProceed: {
			type:    Boolean,
			default: false,
		},
		debug:       {
			type:    Boolean,
			default: false,
		},
		height:      {
			type:    Number,
			default: 550,
		},
	},
	data() {
		return {
			options: {
				uppy:      {
					id:          this.id,
					debug:       this.debug,
					autoProceed: this.autoProceed,
					locale:      Russian,
					restrictions: {
						maxNumberOfFiles: 1,
						minNumberOfFiles: 1,
						allowedFileTypes: ['.xls', '.xlsx'],
					}
				},
				dashboard: {
					inline:                 true,
					target:                 `#${this.id}`,
					width:                  '100%',
					replaceTargetContent:   true,
					showProgressDetails:    true,
					metaFields:             [],
					browserBackButtonClose: true,
				},
				url:       {
					target:       Dashboard,
					companionUrl: 'https://companion.uppy.io/',
				},
				upload:    {
					endpoint: 'https://master.tus.io/files/',
				},
			},
		};
	},
	mounted() {
		window[`uppy-${this.id}`] = new Uppy(this.options.uppy)
			.use(Dashboard, {
				...this.options.dashboard,
				height: this.height,
			})
		window[`uppy-${this.id}`].on('complete', this.onComplete.bind(this));
	},
	methods: {
		onComplete(result) {
			if (result.successful && result.successful.length) {
				this.$emit('complete', {
					files:    result.successful,
				});
			} else {
				this.$emit('error', result);
			}
		},
	},
};
</script>

<style lang="scss">
.file-loader {
}
</style>
