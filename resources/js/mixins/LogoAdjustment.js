export default {
    props: {
        field: {
            type: String,
            required: true,
        },
        module: {
            type: String,
            default: function() {
                return '';
            }
        },
    },
    data() {
        return {
            storeField: Vue.snakeToCamel(this.field),
            storeModule: this.module ? Vue.snakeToCamel(this.module) : '',
        }
    },
    methods: {
        updateValue(value) {
            if (this.storeModule) {
                return this.$store.dispatch(this.storeModule + '/' + Vue.snakeToCamel('update-' + this.storeField), value);
            } else {
                return this.$store.dispatch(Vue.snakeToCamel('update-' + this.storeField), value);
            }
        },
    },
    computed: {
        value: {
            get() {
                if (this.storeModule) {
                    return this.$store.state[this.storeModule][this.storeField];
                } else {
                    return this.$store.state[this.storeField];
                }
            },
            set(value) {
                this.updateValue(value);
            },
        }
    },
}