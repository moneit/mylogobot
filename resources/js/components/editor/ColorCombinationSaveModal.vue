<template>
    <modal-overlay
            :id="id"
            :open="open"
            @update-open="updateOpen"
    >
        <div class="color-combination-save-modal container-fluid">
            <div class="mb-3">Select Color Category</div>
            <div class="row">
                <div class="col-6 col-md-3 palette" v-for="(category, idx) in colorCategories" :key="category.name">
                    <div :class="{'ticked': category.ticked}" @click="tickColorCategory(idx)">
                        <div class="palette-container rounded shadow">
                            <div class="colors-container">
                                <div class="right-rect rounded overflow-hidden">
                                    <div>
                                        <div class="d-flex flex-wrap" v-for="colorSet in category.colors">
                                            <div class="one-third"
                                                 v-for="color in colorSet"
                                            >
                                                <div class="right-rect"
                                                     :style="{backgroundColor: color}"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>Select Color Tones</div>
            <div class="row mb-3">
                <div class="color-tone" v-for="(palette, category) in paletteCategories" :key="category">
                    <div class="w-100 pointer" @click="tickPaletteCategory(category)">
                        <div class="square-box-container">
                            <div class="square-box">
                                <div class="square-box-container">
                                    <div class="square-box rounded-circle shadow" :class="{'ticked': palette.ticked}" :style="{backgroundColor: palette.hex}">
                                        <div style="position: relative;top: 25%;bottom: 25%;left: 25%;right: 25%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    import colorsApi from '../../services/api/colors.js';
    import palettesApi from '../../services/api/palettes.js';
    import colorPaletteApi from '../../services/api/colorPalette.js';
    import colorCategoryPaletteApi from '../../services/api/colorCategoryPalette.js';

    export default {
        name: "ColorCombinationSaveModal",
        mixins: [ModalMixin],
        data() {
            return {
                colorCategories: [],
                paletteCategories: {},
            }
        },
        methods: {
            tickColorCategory(idx) {
                this.colorCategories[idx].ticked = !this.colorCategories[idx].ticked;
                this.colorCategories = this.colorCategories.slice();
            },
            tickPaletteCategory(category) {
                this.paletteCategories[category].ticked = !this.paletteCategories[category].ticked;
                this.paletteCategories[category] = Object.assign({}, this.paletteCategories[category]);
            },
            showErrorMessage(message) {
                this.$emit('show-error-message', message);
            },
            showSuccessMessage(message) {
                this.$emit('show-success-message', message);
            },
            save() {
                let selectedColorCategoriesIds = this.colorCategories
                    .filter(category => category.ticked)
                    .map(category => category.id);

                let selectedColorIds = [];
                for (let category in this.paletteCategories) {
                    if (this.paletteCategories.hasOwnProperty(category)) {
                        if (this.paletteCategories[category].ticked) {
                            selectedColorIds.push(this.paletteCategories[category].id);
                        }
                    }
                }

                palettesApi.store({
                    bg_color: this.$store.getters.backgroundColor,
                    company_name_color: this.$store.getters['companyName/color'].hex,
                    slogan_color: this.$store.getters['slogan/color'].hex,
                    symbol_color: this.$store.getters['symbol/color'].hex,
                })
                    .then((response) => {
                        if (response.status === 'success') {
                            let paletteId = response.payload.palette.id;

                            Promise.all(
                                selectedColorIds.map(colorId =>
                                    colorPaletteApi.store({
                                        color_id: colorId,
                                        palette_id: paletteId,
                                    }).then(res => {
                                        if (res.status === 'failure') {
                                            throw res.payload.message;
                                        }
                                    })
                                ).concat(
                                    selectedColorCategoriesIds.map(colorCategoryId =>
                                        colorCategoryPaletteApi.store({
                                            color_category_id: colorCategoryId,
                                            palette_id: paletteId,
                                        }).then(res => {
                                            if (res.status === 'failure') {
                                                throw res.payload.message;
                                            }
                                        })
                                    )
                                )
                            ).then(() => {
                                this.showSuccessMessage('Color combination successfully saved!');
                                this.updateOpen(false);
                            }).catch(error => {
                                this.showErrorMessage(error);
                            });
                        } else {
                            this.showErrorMessage(response.payload.message);
                        }
                    })
                    .catch(error => {
                        this.showErrorMessage(error);
                    });
            },
        },
        mounted() {
            colorsApi.getColorCategories({}) // init colors
                .then(response => {
                    if (response.status === 'success') {
                        this.colorCategories = response.payload;
                        this.colorCategories.forEach(category => category.ticked = false)
                    }
                });

            colorsApi.getList({}) // init palette categories
                .then(response => {
                    if (response.status === 'success') {
                        this.paletteCategories = response.payload.categories;

                        for (let category in this.paletteCategories) {
                            if (this.paletteCategories.hasOwnProperty(category)) {
                                this.paletteCategories[category].ticked = false;
                            }
                        }
                    }
                });
        }
    }
</script>

<style lang="scss" scoped>
    .color-combination-save-modal {
        width: 324px;

        .palette {

            margin-bottom: 1rem;

            &:first-child {
                margin-left: auto;
            }


            .palette-container {
                cursor: pointer;

                .colors-container {
                    background-color: transparent;

                    .right-rect {
                        width: 100%;
                        padding-top: 100%;
                        position: relative;

                        > div {
                            position: absolute;
                            left: 0;
                            right: 0;
                            top: 0;
                            bottom: 0;

                            .one-third {
                                flex: 0 0 33.3333333333%;
                            }
                        }
                    }
                }
            }

            > .ticked {
                position: relative;

                .palette-container {
                    &::after {
                        content: '';
                        position: absolute;
                        background-color: #1D1E7A;
                        left: 11px;
                        top: 22px;
                        width: 7px;
                        height: 7px;
                        box-shadow:
                                6px 0 0 #1D1E7A,
                                12px 0 0 #1D1E7A,
                                12px -6px 0 #1D1E7A,
                                12px -12px 0 #1D1E7A,
                                12px -18px 0 #1D1E7A,
                                12px -24px 0 #1D1E7A;
                        transform: rotate(45deg);
                    }
                }
            }
        }

        .color-tone {
            flex: 0 0 12.5%;
            max-width: 12.5%;
            padding: 0.25rem !important;

            & > div {
                max-width: 24px;
                max-height: 24px;
                margin: auto;
            }

            & > input[type=checkbox] {
                position: absolute;
                opacity: 0;
            }

            .ticked {
                ::after {
                    content: "";
                    position: absolute;
                    left: 1px;
                    top: 5px;
                    background: white;
                    width: 3px;
                    height: 3px;
                    box-shadow: 2px 0 0 white, 4px 0 0 white, 4px -2px 0 white, 4px -4px 0 white, 4px -6px 0 white, 4px -8px 0 white;
                    transform: rotate(45deg);
                }
            }
        }
    }
</style>