<template>
    <div :style="style">
        <div class="device-md d-md-none"></div>
        <div class="row">
            <div class="col-4 col-md-6 my-3"
                 v-for="(option, idx) in options"
                 :key="option.id"
                 v-show="idx >= lb && idx < ub"
            >
                <div class="square-box-container shadow">
                    <div class="square-box d-flex justify-content-center align-items-center pointer">
                        <input type="radio" :id="option.id" :name="'container_' + option.id" :value="option" v-model="selectedContainer" @click="onRadioClick">
                        <label :for="option.id" class="d-flex w-100 h-100 pointer">
                            <img :src="'/storage/containers/' + option.file_name" class="w-100"/>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row nav-dots">
            <div v-for="page in pages"
                 class="nav-dot"
                 :class="currentPage === page - 1 ? 'selected' : ''"
                 @click="currentPage = page - 1"
            ></div>
        </div>
    </div>
</template>

<script>
    import LogoAdjustment from '../../mixins/LogoAdjustment.js';

    export default {
        name: "ContainerSelector",
        mixins: [LogoAdjustment],
        data() {
            return {
                style: {
                    margin: '0 15px',
                },
                currentPage: 0,
                limit: 8
            }
        },
        methods: {
            onRadioClick($event) {
                if ($event.target._value.id === this.value.id) {
                    this.updateValue({});
                }
            }
        },
        computed: {
            options() {
                return this.$store.state.container.list;
            },
            selectedContainer: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.updateValue(value);
                }
            },
            pages() {
                return Math.ceil(this.options.length / this.limit);
            },
            lb() {
                return this.currentPage * this.limit;
            },
            ub() {
                return (1 + this.currentPage) * this.limit;
            }
        },
        mounted() {
            if ($(this.$el.children[0]).css('display') === 'block') { // < md view
                this.limit = 6;
            }
        }
    }
</script>

<style scoped>
    input[type=radio] {
        display: none;
    }

    input + label {
        border-bottom: 2px solid transparent;
    }

    input:checked + label {
        border-bottom: 2px solid #1D1E7A;
    }

    .nav-dots {
        width: 100%;
        bottom: -9px;
        height: 11px;
        display: block;
        position: absolute;
        text-align: center;
    }

    .nav-dots .nav-dot {
        top: -5px;
        width: 11px;
        height: 11px;
        margin: 0 4px;
        position: relative;
        border-radius: 100%;
        display: inline-block;
        background-color: #ACB4B9;
    }

    .nav-dots .nav-dot:hover, .nav-dots .nav-dot.selected {
        cursor: pointer;
        background-color: #1D1E7A;
    }
</style>