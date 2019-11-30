<template>
    <div class="saved-logos">
        <div class="row">
            <div class="col-md-4" v-for="logo in savedLogos" :key="logo.ts" style="padding: 15px;">
                <div class="logo-view-container shadow">
                    <a href="/editor" @click="storeIntoLocal(logo)" @auxclick="storeIntoLocal(logo)">
                        <div class="logo-view">
                            <logo-preview-wrapper
                                    v-if="logo.settings"
                                    class="rounded"
                                    :preview-settings="logo"
                                    @preview-fail="previewFailedIndexes.push(logo.ts)"
                                    :show-water-mark="true"
                            ></logo-preview-wrapper>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import logoApi from '../services/api/logo';
    import lsHelper from '../helpers/localStorageHelper.js';
    import LogoPreviewWrapper from './logo/LogoPreviewWrapper';

    export default {
        name: "SavedLogos",
        components: {
            LogoPreviewWrapper
        },
        data() {
            return {
                savedLogos: [],
                previewFailedIndexes: [],
            };
        },
        mounted() {
            logoApi.getSavedLogos({}, (res) => {
                if (res.status === 'success') {
                    this.savedLogos = res.payload.list;
                }
            });
        },
        methods: {
            storeIntoLocal(logoSettings) {
                lsHelper.set('logoSettings', logoSettings);
            },
        }
    }
</script>

<style scoped>

</style>