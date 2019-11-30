<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         xmlns:xlink="http://www.w3.org/1999/xlink"
         :width="width"
         :height="height"
         :viewBox="'0 0 ' + width + ' ' + height"
         fill="none"
    >
        <rect v-if="backgroundColor" id="background" :width="width" :height="height" :fill="backgroundColor"></rect>
        <logo-symbol
                preview-mode
                :preview-settings.sync="symbolPreviewSettings"
                :preview-fail.sync="symbolPreviewFail"
                :transform="symbolTransform"
        ></logo-symbol>
    </svg>
</template>

<script>
    import LogoSymbol from '../logo/components/Symbol.vue';
    import LogoPlacementMixin from '../../mixins/LogoPlacement.js';

    export default {
        name: "LogoSymbolPreview",
        props: {
            previewSettingsProp: {
                type: Object,
                required: false,
            },
            containerPreviewSettingsProp: {
                type: Object,
                required: false,
            },
            symbolPreviewSettingsProp: {
                type: Object,
                required: false,
            },
            companyNamePreviewSettingsProp: {
                type: Object,
                required: false,
            },
            sloganPreviewSettingsProp: {
                type: Object,
                required: false,
            },
            refresh: {
                type: Boolean,
                default: function() {
                    return false;
                }
            }
        },
        mixins: [LogoPlacementMixin],
        components: {
            LogoSymbol,
        },
        data() {
            const logoSettings = this.$store.getters.logoSettings;

            return {
                symbolPreviewFail: false,
                previewSettings: Object.assign({}, logoSettings.settings, this.previewSettingsProp),
                containerPreviewSettings: Object.assign({}, logoSettings.containerSettings, this.containerPreviewSettingsProp),
                symbolPreviewSettings: Object.assign({}, logoSettings.symbolSettings, this.symbolPreviewSettingsProp),
                companyNamePreviewSettings: Object.assign({}, logoSettings.companyNameSettings, this.companyNamePreviewSettingsProp),
                sloganPreviewSettings: Object.assign({}, logoSettings.sloganSettings, this.sloganPreviewSettingsProp),
            }
        },
        computed: {
            previewFail() {
                return this.containerPreviewFail || this.companyNamePreviewFail || this.sloganPreviewFail || this.symbolPreviewFail;
            },

            layout: {
                get() {
                    return this.previewSettings.layout;
                },
                set(layout) {
                    this.previewSettings.layout = layout;
                },
            },
            backgroundColor() {
                return this.previewSettings.backgroundColor.hex;
            },
            width() {
                return this.previewSettings.width;
            },
            height() {
                return this.previewSettings.height;
            },
            scale: {
                get() {
                    return this.previewSettings.scale;
                },
                set(scale) {
                    this.previewSettings.scale = scale;
                }
            },

            containerScale() {
                if (this.containerPreviewSettings.viewBox.maxX - this.containerPreviewSettings.viewBox.minX === 0) {
                    return 1;
                } else {
                    return this.previewSettings.width / 100 * this.containerPreviewSettings.size / (this.containerPreviewSettings.viewBox.maxX - this.containerPreviewSettings.viewBox.minX);
                }
            },
            containerWidth() {
                return (this.containerPreviewSettings.viewBox.maxX - this.containerPreviewSettings.viewBox.minX) * this.containerScale;
            },
            containerHeight() {
                return (this.containerPreviewSettings.viewBox.maxY - this.containerPreviewSettings.viewBox.minY) * this.containerScale;
            },

            companyNameScale() {
                return this.companyNamePreviewSettings.scale;
            },
            companyNameIsPlaced() {
                return false;
            },
            companyNameWidth() {
                return this.companyNamePreviewSettings.width * this.companyNameScale;
            },
            companyNameHeight() {
                return this.companyNamePreviewSettings.height * this.companyNameScale;
            },
            companyNameLineSpaceRate() {
                return (this.companyNamePreviewSettings.lineSpace - 50) / 50;
            },

            sloganScale() {
                return this.sloganPreviewSettings.scale;
            },
            sloganWidth() {
                return this.sloganPreviewSettings.width * this.sloganScale;
            },
            sloganHeight() {
                return this.sloganPreviewSettings.height * this.sloganScale;
            },
            sloganIsPlaced() {
                return false;
            },
            sloganLineSpaceRate() {
                return (this.sloganPreviewSettings.lineSpace - 50) / 50;
            },

            symbolType() {
                return this.symbolPreviewSettings.types.find(type => type.selected);
            },
            symbolScale() {
                if (this.symbolType.label === 'Icon') { // icons
                    if (this.symbolPreviewSettings.iconWidth === 0 || this.symbolPreviewSettings.iconHeight === 0) {
                        return 1;//todo: scale should never be 0 not to break PDF export
                    } else {
                        return 512 / Math.max(this.symbolPreviewSettings.iconWidth, this.symbolPreviewSettings.iconHeight);
                    }
                } else {
                    if (this.symbolPreviewSettings.initialsWidth === 0 || this.symbolPreviewSettings.initialsHeight === 0) {
                        return 1;//todo: scale should never be 0 not to break PDF export
                    } else {
                        return 512 / Math.max(this.symbolPreviewSettings.initialsWidth, this.symbolPreviewSettings.initialsHeight);
                    }
                }
            },
            symbolWidth() {
                if (this.symbolIsPlaced) {
                    if (this.symbolType.label === 'Icon') { // icons
                        return this.symbolPreviewSettings.iconWidth * this.symbolScale;
                    } else {
                        return this.symbolPreviewSettings.initialsWidth * this.symbolScale;
                    }
                } else {
                    return 0;
                }
            },
            symbolHeight() {
                if (this.symbolIsPlaced) {
                    if (this.symbolType.label === 'Icon') { // icons
                        return this.symbolPreviewSettings.iconHeight * this.symbolScale;
                    } else {
                        return this.symbolPreviewSettings.initialsHeight * this.symbolScale;
                    }
                } else {
                    return 0;
                }
            },
            symbolIsPlaced() {
                return (
                    this.symbolType.label === 'Icon' &&
                    !this.symbolPreviewSettings.iconHidden &&
                    this.symbolPreviewSettings.tags.length
                ) || (
                    this.symbolType.label === 'Initials' &&
                    this.symbolPreviewSettings.text
                );
            },
            symbolLineSpaceRate() {
                return (this.symbolPreviewSettings.lineSpace - 50) / 50;
            },
        },
    }
</script>

<style lang="scss" scoped>

</style>