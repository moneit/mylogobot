<template>
    <logo-symbol-preview
        :preview-settings-prop="previewSettings.settings"
        :container-preview-settings-prop="previewSettings.containerSettings"
        :company-name-preview-settings-prop="previewSettings.companyNameSettings"
        :slogan-preview-settings-prop="previewSettings.sloganSettings"
        :symbol-preview-settings-prop="previewSettings.symbolSettings"
    ></logo-symbol-preview>
</template>

<script>
    import LogoSymbolPreview from './LogoSymbolPreview';

    export default {
        name: "LogoSymbolPreviewWrapper",
        components: { LogoSymbolPreview },
        props: {
            previewSettings: {
                type: Object,
                default: function() {
                    return {}
                }
            },
        },
    }
</script>

<style scoped>

</style>