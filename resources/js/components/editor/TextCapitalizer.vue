<template>
    <div class="row">
        <div class="col-4" v-for="option in options" :key="option">
            <input type="radio" :id="module + '_' + option" :name="module + '_capitalizer'" :value="option" v-model="selectedValue" @click="onRadioClick">
            <label :for="module + '_' + option" class="w-100">
                <div class="border rounded cap-box">
                    <div class="icon">
                        <svg viewBox="0 0 69 41">
                            <text x="34.5" y="29" style="font-size: 32px; text-anchor: middle;" :class="'text-' + option">
                                aa
                            </text>
                        </svg>
                        <svg viewBox="0 0 86 18">
                            <text x="43" y="14" style="font-family: Montserrat; font-size: 16px; text-anchor: middle;" class="text-capitalize">
                                {{ option }}
                            </text>
                        </svg>
                    </div>
                </div>
            </label>
        </div>
    </div>
</template>

<script>
    import LogoAdjustment from '../../mixins/LogoAdjustment.js';

    export default {
        name: "TextCapitalizer",
        mixins: [LogoAdjustment],
        data() {
            return {
                options: ['uppercase', 'lowercase', 'capitalize', ],
            }
        },
        methods: {
            onRadioClick($event) {
                if (this.value && $event.target.value === this.value) {
                    this.updateValue('');
                }
            }
        },
        computed: {
            selectedValue: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.updateValue(value);
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    input[type=radio] {
        display: none;

        & + label {
            cursor: pointer;

            .cap-box {
                position: relative;
                padding-bottom: 100%;

                .icon {
                    position: absolute;
                    left: 10%;
                    right: 10%;
                    top: 16.66%;
                    bottom: 16.66%;
                    text-align: center;
                    font-family: none;
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                }
            }
        }

        &:checked + label {
            .cap-box {
                background-color: #374047;

                text {
                    fill: white;
                }
            }
        }
    }
</style>