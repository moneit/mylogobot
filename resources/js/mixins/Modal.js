import uid from '../helpers/uniqueIdHelper.js';
import ModalOverlay from '../components/modals/ModalOverlay.vue';

export default {
    components: {
        ModalOverlay
    },
    props: {
        open: {
            type: Boolean,
            required: true,
        }
    },
    data() {
        return {
            id: uid.generate(),
        }
    },
    methods: {
        updateOpen(value) {
            this.$emit('update-open', value);
        }
    },
}