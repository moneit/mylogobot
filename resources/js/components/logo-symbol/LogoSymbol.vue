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
            :transform="symbolTransform"
        ></logo-symbol>
    </svg>
</template>

<script>
    import LogoSymbol from '../logo/components/Symbol.vue';
    import LogoPlacementMixin from '../../mixins/LogoPlacement.js';

    export default {
        name: "LogoSymbolOnly",
        props: {
            draggable: {
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
        computed: {
            layout: {
                get() {
                    return this.$store.state.layout;
                },
                set(layout) {
                    this.$store.dispatch('updateLayout', layout);
                },
            },
            backgroundColor() {
                return this.$store.getters.backgroundColor;
            },
            width() {
                return this.$store.state.width;
            },
            height() {
                return this.$store.state.height;
            },
            scale: {
                get() {
                    return this.$store.state.scale;
                },
                set(scale) {
                    this.$store.dispatch('updateScale', scale);
                }
            },
            containerWidth() {
                return this.$store.getters['container/width'];
            },
            containerHeight() {
                return this.$store.getters['container/height'];
            },
            containerScale() {
                return this.$store.getters['container/scale'];
            },
            companyNameWidth() {
                return this.$store.getters['companyName/width'];
            },
            companyNameHeight() {
                return this.$store.getters['companyName/height'];
            },
            companyNameScale() {
                return this.$store.state.companyName.scale;
            },
            companyNameIsPlaced() {
                return false;
            },
            companyNameLineSpaceRate() {
                return this.$store.getters['companyName/lineSpaceRate'];
            },
            sloganWidth() {
                return this.$store.getters['slogan/width'];
            },
            sloganHeight() {
                return this.$store.getters['slogan/height'];
            },
            sloganScale() {
                return this.$store.state.slogan.scale;
            },
            sloganIsPlaced() {
                return false;
            },
            sloganLineSpaceRate() {
                return this.$store.getters['slogan/lineSpaceRate'];
            },
            symbolType() {
                return this.$store.getters['symbol/type'];
            },
            symbolScale() {
                if (this.symbolType.label === 'Icon') { // icons
                    if (this.$store.state.symbol.iconWidth === 0 || this.$store.state.symbol.iconHeight === 0) {
                        return 1;//todo: scale should never be 0 not to break PDF export
                    } else {
                        return 512 / Math.max(this.$store.state.symbol.iconWidth, this.$store.state.symbol.iconHeight);
                    }
                } else {
                    if (this.$store.state.symbol.initialsWidth === 0 || this.$store.state.symbol.initialsHeight === 0) {
                        return 1;//todo: scale should never be 0 not to break PDF export
                    } else {
                        return 512 / Math.max(this.$store.state.symbol.initialsWidth, this.$store.state.symbol.initialsHeight);
                    }
                }
            },
            symbolWidth() {
                if (this.symbolIsPlaced) {
                    if (this.$store.state.symbol.types[0].selected) { // icons
                        return this.$store.state.symbol.iconWidth * this.symbolScale;
                    } else {
                        return this.$store.state.symbol.initialsWidth * this.symbolScale;
                    }
                } else {
                    return 0;
                }
            },
            symbolHeight() {
                if (this.symbolIsPlaced) {
                    if (this.$store.state.symbol.types[0].selected) { // icons
                        return this.$store.state.symbol.iconHeight * this.symbolScale;
                    } else {
                        return this.$store.state.symbol.initialsHeight * this.symbolScale;
                    }
                } else {
                    return 0;
                }
            },
            symbolIsPlaced() {
                return !!this.$store.getters['symbol/isPlaced'];
            },
            symbolLineSpaceRate() {
                return this.$store.getters['symbol/lineSpaceRate'];
            },
        },
    }
</script>

<style scoped>

</style>