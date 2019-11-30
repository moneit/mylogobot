export default {
    props: {
        refresh: {
            type: Boolean,
            default: function() {
                return false;
            }
        },
    },
    watch: {
        refresh(value) {
            if (value) {
                const logoSettings = this.$store.getters.logoSettings;

                this.previewSettings = Object.assign({}, logoSettings.settings, this.previewSettingsProp);
                this.containerPreviewSettings = Object.assign({}, logoSettings.containerSettings, this.containerPreviewSettingsProp);
                this.symbolPreviewSettings = Object.assign({}, logoSettings.symbolSettings, this.symbolPreviewSettingsProp);
                this.companyNamePreviewSettings = Object.assign({}, logoSettings.companyNameSettings, this.companyNamePreviewSettingsProp);
                this.sloganPreviewSettings = Object.assign({}, logoSettings.sloganSettings, this.sloganPreviewSettingsProp);
            }
        },
    },
}