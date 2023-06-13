export default {
    props: {
        modelValue: {
            type: [Number, String, Object, Array, Boolean, Date],
            default: '',
        },
    },
    computed: {
        model: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            },
        },
    },
    methods: {
        change(event) {
            this.model = event.target && event.target.value !== undefined ? event.target.value : event;
        },
    },
};
