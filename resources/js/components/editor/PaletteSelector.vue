<template>
    <div class="palette-selector">
        <color-selector class="mb-3" label="Background Color" field="background-color"></color-selector>
        <div class="text-center mb-3">
            1. Choose main tone
        </div>
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="row">
                    <div class="col-3 p-3" v-for="(palette, category) in paletteCategories" :key="category">
                        <input type="radio" :id="category" name="palette" :value="palette" v-model="selectedPalette">
                        <label :for="category" class="w-100 pointer">
                            <div class="square-box-container">
                                <div class="square-box">
                                    <div class="square-box-container">
                                        <div class="square-box rounded-circle shadow" :style="{backgroundColor: palette.hex}">
                                            <div style="position: relative;top: 25%;bottom: 25%;left: 25%;right: 25%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center mb-3">
            2. Choose color scheme
        </div>
        <div class="row color-scheme-selector">
            <div class="color-scheme-scroller">
                <div class="col-lg-8 offset-lg-2">
                    <div class="row my-1 py-2 pointer border-transparent"
                         :key="idx"
                         v-for="(option, idx) in paletteOptions"
                         :class="{'border rounded': isMatching(option)}"
                         @click="applyPalette(option)">
                        <div class="col-3 p-3">
                            <div class="square-box">
                                <div class="square-box-container">
                                    <div class="square-box rounded-circle shadow" :style="{backgroundColor: option.bg_color, padding: '25%'}"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 p-3">
                            <div class="square-box">
                                <div class="square-box-container">
                                    <div class="square-box rounded-circle shadow" :style="{backgroundColor: option.company_name_color, padding: '25%'}"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 p-3">
                            <div class="square-box">
                                <div class="square-box-container">
                                    <div class="square-box rounded-circle shadow" :style="{backgroundColor: option.slogan_color, padding: '25%'}"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3 p-3">
                            <div class="square-box">
                                <div class="square-box-container">
                                    <div class="square-box rounded-circle shadow" :style="{backgroundColor: option.symbol_color, padding: '25%'}"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ColorSelector from './ColorSelector.vue';

    export default {
        name: "PaletteSelector",
        components: {
            ColorSelector
        },
        methods: {
            applyPalette(option) {
                this.$store.dispatch('applyPalette', option);
            },
            isMatching(option) {
                return option.bg_color === this.backgroundColor
                    && option.company_name_color === this.companyNameColor
                    && option.slogan_color === this.sloganColor
                    && option.symbol_color === this.symbolColor;
            }
        },
        computed: {
            paletteCategories() {
                return this.$store.state.paletteCategories;
            },
            paletteOptions() {
                return this.$store.state.paletteOptions;
            },
            selectedPalette: {
                get() {
                    return this.$store.getters.palette;
                },
                set(value) {
                    this.$store.dispatch('updatePalette', value);
                }
            },
            backgroundColor() {
                return this.$store.state.backgroundColor.hex;
            },
            companyNameColor() {
                return this.$store.state.companyName.color.hex;
            },
            sloganColor() {
                return this.$store.state.slogan.color.hex;
            },
            symbolColor() {
                return this.$store.state.symbol.color.hex;
            },
        },
    }
</script>

<style scoped>
    .palette-selector > *:first-child >>> *:first-child { /* color selector centering */
        margin-left: auto;
    }
    .palette-selector > *:first-child >>> *:last-child { /* color selector centering */
        margin-right: auto;
    }
    .color-scheme-selector div.row > div:first-child { /* mobile view */
        margin-left: auto;
    }
    .color-scheme-selector div.row > div:last-child { /* mobile view */
        margin-right: auto;
    }
    .color-scheme-scroller {
        width: 100%;
        overflow-y: auto;
    }
    .border-transparent {
        border: 1px solid transparent;
    }
</style>