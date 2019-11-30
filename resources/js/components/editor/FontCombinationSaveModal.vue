<template>
    <modal-overlay
            :id="id"
            :open="open"
            @update-open="updateOpen"
    >
        <div class="font-combination-save-modal container-fluid">
            <div class="mb-2">Select Logo Category</div>

            <div class="row logo-samples-container mb-2">
                <div class="col-6 col-md-4" v-for="kind in kinds" :key="kind.id" style="min-width: 300px;">
                    <input type="radio" :id="'logo_sample_' + kind.id" :value="kind" v-model="value">
                    <label :for="'logo_sample_' + kind.id" class="w-100">
                        <component :is="kind.component"></component>
                    </label>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label :for="id" class="w-100 h-100 btn btn-outline-dark pointer">
                        Cancel
                    </label>
                </div>
                <div class="col-6">
                    <label class="w-100 h-100 btn btn-theme gradient-secondary-90 pointer" @click="save">
                        Save
                    </label>
                </div>
            </div>
        </div>
    </modal-overlay>
</template>

<script>
    import ModalMixin from '../../mixins/Modal.js';
    import fontRecommendationsIconLogoApi from '../../services/api/fontRecommendationsIconLogo.js';
    import fontRecommendationsInitialsLogoApi from '../../services/api/fontRecommendationsInitialsLogo.js';
    import fontRecommendationsTypographyLogoApi from '../../services/api/fontRecommendationsTypographyLogo.js';

    export default {
        name: "FontCombinationSaveModal",
        mixins: [ModalMixin],
        data() {
            return {
                value: {}
            }
        },
        methods: {
            showErrorMessage(message) {
                this.$emit('show-error-message', message);
            },
            showSuccessMessage(message) {
                this.$emit('show-success-message', message);
            },
            save() {
                if (this.value.layout) {
                    let promise;

                    switch(this.value.layout) {
                        case 'icon':
                            promise = fontRecommendationsIconLogoApi.store({
                                'company_name_font_id': this.companyNameFontId,
                                'slogan_font_id': this.sloganFontId,
                            });
                            break;
                        case 'initial':
                            promise = fontRecommendationsInitialsLogoApi.store({
                                'company_name_font_id': this.companyNameFontId,
                                'slogan_font_id': this.sloganFontId,
                                'initials_font_id': this.initialsFontId,
                            });
                            break;
                        case 'typography':
                            promise = fontRecommendationsTypographyLogoApi.store({
                                'company_name_font_id': this.companyNameFontId,
                                'slogan_font_id': this.sloganFontId,
                            });
                            break;
                    }

                    if (promise) {
                        promise.then((res) => {
                            if (res.status === 'success') {
                                this.showSuccessMessage('Font combination successfully saved!');
                                this.updateOpen(false);
                            } else {
                                throw res.payload.message;
                            }
                        }).catch(error => {
                            this.showErrorMessage(error);
                        })
                    }
                }
            }
        },
        computed: {
            kinds() {
                return this.$store.state.kinds;
            },
            companyNameFontId() {
                return this.$store.state.companyName.font.id;
            },
            sloganFontId() {
                return this.$store.state.slogan.font.id;
            },
            initialsFontId() {
                return this.$store.state.symbol.font.id;
            }
        }
    }
</script>

<style scoped>
    .font-combination-save-modal {
        /*width: 324px;*/
    }
    input[type=radio] {
        position: absolute;
        opacity: 0;
    }
    input + label {
        border: 1px solid transparent;
    }
    input:checked + label {
        border-color: green;
    }
</style>