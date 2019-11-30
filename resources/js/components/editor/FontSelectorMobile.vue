<template>
    <div>
        <label :for="module + '-font-selector-toggle-mobile'" class="btn btn-outline-dark w-100">Change Font</label>
        <div>
            <input :id="module + '-font-selector-toggle-mobile'" class="font-selector-toggle" type="checkbox" v-model="open">
            <label :for="module + '-font-selector-toggle-mobile'" class="overlay"></label>
            <div class="font-selector d-flex border">
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
    const FontSelector = Vue.component('font-selector', require('./FontSelector.vue').default);

    const FontSelectorMobile = FontSelector.extend({
        name: "FontSelectorMobile",
    });

    export default FontSelectorMobile;
</script>

<style lang="scss" scoped>
    .font-selector-toggle {
        display: none;
    }

    .font-selector {
        position: fixed;
        top: 5rem;
        bottom: 5rem;
        right: 1rem;
        left: 1rem;
        z-index: 1031;
        transition: all 0.3s ease-in-out;
        pointer-events: none;
        opacity: 0;

        input.font-selector-toggle[type=checkbox]:checked ~ & {
            pointer-events: auto;
            opacity: 1;
        }

        > :first-child {
            width: 40%;
        }

        > :last-child {
            width: 60%;
        }

        .tab-content {
            overflow: auto;
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
            text-align: center;
            cursor: pointer;
            width: 100%;
            height: 20%;

            .nav-link {
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                border: none;
                border-radius: 0;
                color: #374047;

                &:not(.active) {
                    color: #ACB4B9;

                    &:hover {
                        background-color: #e9ecef;
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