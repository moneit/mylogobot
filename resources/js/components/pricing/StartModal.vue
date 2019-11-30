<template>
    <modal-overlay
            :id='id'
            :open='open'
            @update-open='updateOpen'
    >
        <div class='store-success-modal container-fluid'>
            <div class='row d-block color-primary my-3' style='font-size: 2rem;'>
                Get Started
            </div>
            <div class='row my-1'>
                <p class='w-100'>
                    Tell me what your company name is.
                </p>
            </div>
            <div class='row'>
                <form-input
                        class='w-100 text-left'
                        field='company_name'
                        label='Your company name'
                        v-model='companyName'
                ></form-input>
            </div>
            <div class='row'>
                <div class='w-100 h-100 btn btn-theme gradient-secondary-90 mb-3 pointer' style='padding: 0.75rem;' @click="start">
                    Start Creating
                </div>
            </div>
        </div>
    </modal-overlay>
</template>

<script>
    import ModalMixin from '../../mixins/Modal.js';
    import FormInput from '../FormInput.vue';
    import { CONVERSATION_PAGE } from '../../services/routing/pages.js';
    import router from '../../services/routing/router.js';

    export default {
        name: 'StartModal',
        mixins: [ModalMixin],
        components: {
            FormInput,
        },
        data() {
            return {
                companyName: '',
            }
        },
        methods: {
            start() {
                if (this.companyName) {
                    this.$store.dispatch('updateCompanyName', this.companyName);
                    this.$store.dispatch('storeLogoInfo');
                    router.goToPage(CONVERSATION_PAGE);
                }
            }
        }
    }
</script>

<style scoped>
    .store-success-modal {
        width: 324px;
    }
</style>