<template>
    <div class="row" :class="beforeSelect || selectedColorCategoriesIds.length ? 'm-4' : ''">
        <div class="col-6 col-md-3 palette" :class="{'checked': (!beforeSelect && category.checked)}" v-for="category in categories" :key="category.name" v-if="beforeSelect || (!beforeSelect && category.checked)">
            <input type="checkbox" :id="category.name" :checked="category.checked" @change="updateCheck" :disabled="disabled"/>
            <label :for="category.name" :class="(!beforeSelect && category.checked) ? 'background-primary' : 'background-white'">
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
                    <div class="name-container text-center">
                        <label :for="category.name" class="check-mark" :class="(!beforeSelect && category.checked) ? 'color-white' : 'color-black'">
                            {{ category.name }}
                        </label>
                    </div>
                </div>
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PaletteOptions",
        methods: {
            updateCheck($event) {
                this.$store.dispatch('updateCheckedColorCategory', {
                    name: $event.target.id,
                    checked: $event.target.checked,
                });
            }
        },
        computed: {
            categories() {
                return this.$store.state.colorCategories;
            },
            selectedColorCategoriesIds() {
                return this.$store.getters.selectedColorCategoriesIds;
            },
            stage() {
                return this.$store.state.conversation.stage;
            },
            disabled() {
                return this.stage > 4;
            },
            beforeSelect() {
                return this.stage === 4;
            },
        },
    }
</script>

<style lang="scss" scoped>
    .palette {

        margin-bottom: 1rem;

        &:first-child {
            margin-left: auto;
        }

        & > input[type=checkbox] {
            position: absolute;
            opacity: 0;

            & + label {
                width: 100%;

                .palette-container {
                    cursor: pointer;

                    .colors-container {
                        padding: 5px;

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
                    .name-container {
                        padding: 10px;

                        .check-mark {
                            cursor: pointer;
                            font-size: .9em;

                            &::before {
                                content: '';
                                display: inline-block;
                                vertical-align: text-top;
                                width: 20px;
                                height: 20px;
                                margin-right: 5px;
                                background: white;
                                -webkit-border-radius: 1px;
                                -moz-border-radius: 1px;
                                border-radius: 1px;
                                border: 1px solid #DEE1E3;
                            }

                            position: relative;
                            display: inline;
                            padding: 0;
                        }
                    }
                }
            }

            &:not([disabled]):hover + label {
                .palette-container {
                    .name-container {
                        .check-mark {
                            &::before {
                                border: 1px solid #02DE84;
                            }
                        }
                    }
                }
            }

            &:checked + label {
                .palette-container {
                    .name-container {
                        .check-mark {
                            &::before {
                                background: #02DE84;
                                border: 1px solid #02DE84;
                            }

                            &::after {
                                content: '';
                                position: absolute;
                                left: 5px;
                                top: 9px;
                                background: white;
                                width: 2px;
                                height: 2px;
                                box-shadow:
                                        2px 0 0 white,
                                        4px 0 0 white,
                                        4px -2px 0 white,
                                        4px -4px 0 white,
                                        4px -6px 0 white,
                                        4px -8px 0 white;
                                transform: rotate(45deg);
                            }
                        }
                    }
                }
            }
        }
    }
</style>