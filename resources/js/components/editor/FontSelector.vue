<template>
    <div>
        <label :for="module + '-font-selector-toggle'" class="btn btn-outline-dark w-100">Change Font</label>
        <div>
            <input :id="module + '-font-selector-toggle'" class="font-selector-toggle" type="checkbox" v-model="open">
            <label :for="module + '-font-selector-toggle'" class="overlay"></label>
            <div class="font-selector">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <template v-for="(fonts, category, idx) in fontCategories">
                        <li class="nav-item" :class="category.toLowerCase()">
                            <a class="nav-link" :class="{'active': idx === selectedIdx}" role="tab" @click.stop.prevent="selectTab(idx)">{{ category }}</a>
                        </li>
                    </template>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <template v-for="(fonts, category, idx) in fontCategories">
                        <div class="tab-pane p-3 fade show active" v-if="idx === selectedIdx" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 font-card"
                                     v-for="(font, fontIdx) in fonts"
                                     v-if="fontIdx < count"
                                     :key="font.id"
                                     @click="selectFont(font)"
                                >
                                    <div class="panel-container">
                                        <div class="panel" :style="{backgroundColor: backgroundColor.hex}">
                                            <template v-if="module === 'company-name'">
                                                <logo-preview v-if="open"
                                                      :company-name-preview-settings-prop="{font: font}"
                                                ></logo-preview>
                                            </template>
                                            <template v-if="module === 'slogan'">
                                                <logo-preview v-if="open"
                                                      :slogan-preview-settings-prop="{font: font}"
                                                ></logo-preview>
                                            </template>
                                            <template v-if="module === 'symbol'">
                                                <logo-preview v-if="open"
                                                      :symbol-preview-settings-prop="{font: font}"
                                                ></logo-preview>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LogoPreview from '../logo/LogoPreview.vue';
    import LogoAdjustment from '../../mixins/LogoAdjustment.js';

    export default {
        name: "FontSelector",
        mixins: [LogoAdjustment],
        components: {
            LogoPreview,
        },
        data() {
            return {
                open: false,
                count: 0,
                limit: 0,
                selectedIdx: 0,
            }
        },
        computed: {
            fontCategories() {
                return this.$store.state.fontCategories;
            },
            backgroundColor() {
                return this.$store.state.backgroundColor;
            },
        },
        methods: {
            selectTab(idx) {
                this.selectedIdx = idx;
                this.count = 0;
                this.limit = 0;
                this.updateCount();
            },
            selectFont(font) {
                this.updateValue(font);
                this.open = false;
            },
            updateCount() {
                if (Object.keys(this.fontCategories).length > 0) {
                    this.limit = this.fontCategories[Object.keys(this.fontCategories)[this.selectedIdx]].length;
                    if (this.count < this.limit) {
                        if (this.count + 6 > this.limit) {
                            this.count = this.limit;
                        } else {
                            this.count += 6;
                            setTimeout(() => {
                                this.updateCount();
                            }, 2000);
                        }
                    }
                } else {
                    setTimeout(() => {
                        this.updateCount();
                    }, 2000);
                }
            }
        },
        watch: {
            open(value) {
                if (this.open) {
                    this.updateCount();
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .font-selector-toggle {
        display: none;
    }

    .font-selector {overflow: auto;
        position: fixed;
        top: calc((100vh - ((100vmin - 90px) * 0.625 + 90px)) / 2);
        bottom: calc((100vh - ((100vmin - 90px) * 0.625 + 90px)) / 2);
        right: calc((100vw - 100vmin) / 2);
        left: calc((100vw - 100vmin) / 2);
        z-index: 1031;
        transition: all 0.3s ease-in-out;
        pointer-events: none;
        opacity: 0;

        input.font-selector-toggle[type=checkbox]:checked ~ & {
            pointer-events: auto;
            opacity: 1;
        }
    }

    .font-selector-toggle + .overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1030;
        opacity: 0;
        transition: all 0.3s ease-in-out;
        pointer-events: none;
    }

    input.font-selector-toggle[type=checkbox]:checked + .overlay {
        pointer-events: auto;
        opacity: 1;
    }

    .font-selector {
        background-color: white;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }

    .panel-container {
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
        &:hover {
            cursor: pointer;
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175);
        }
    }

    ul.nav.nav-tabs {
        display: flex;
        background-color: #DEE1E3;

        li.nav-item {
            flex: 1;
            text-align: center;
            cursor: pointer;

            .nav-link {
                color: #374047;

                &:not(.active) {
                    color: #ACB4B9;

                    &:hover {
                        background-color: #e9ecef;
                        border-color: transparent;
                    }
                }
            }
        }
    }

    .row {
        margin-top: -15px;
        margin-bottom: -15px;

        .font-card {
            padding: 15px;
        }
    }

    .serif {
        font-family: 'Merriweather';
    }

    .sans-serif {
        font-family: 'Roboto';
    }

    .display {
        font-family: 'Righteous';
    }

    .handwriting {
        font-family: 'Pacifico';
    }

    .monospace {
        font-family: 'PT Mono';
    }
</style>