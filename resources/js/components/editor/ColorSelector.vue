<template>
    <div class="d-flex align-items-center">
        <span class="mr-1">{{ label }}</span>
        <label :for="module + '-color-selector-toggle'" class="color-selector-toggle border" :style="{backgroundColor: value.hex}"></label>
        <div class="position-relative">
            <input :id="module + '-color-selector-toggle'" class="d-none color-selector-toggle" type="checkbox">
            <label :for="module + '-color-selector-toggle'" class="overlay"></label>
            <chrome-picker class="color-selector" v-model="value" />
        </div>
    </div>
</template>

<script>
    import LogoAdjustment from '../../mixins/LogoAdjustment.js';
    import { Chrome } from 'vue-color';

    export default {
        name: "ColorSelector",
        props: {
            label: {
                type: String,
                default: function() {
                    return 'Color';
                }
            }
        },
        mixins: [LogoAdjustment],
        components: {
            'chrome-picker': Chrome,
        },
    }
</script>

<style lang="scss" scoped>
    label.color-selector-toggle {
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        width: 1rem;
        height: 1rem;
        cursor: pointer;
    }

    .color-selector {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1031;
        transition: all 0.3s ease-in-out;
        pointer-events: none;
        opacity: 0;

        input.color-selector-toggle[type=checkbox]:checked ~ & {
            pointer-events: auto;
            opacity: 1;
        }
    }

    @media (max-width: 767px) {
        .color-selector {
            bottom: 9px;
            right: 0;
            top: unset;
            left: unset;
        }
    }

    input.color-selector-toggle + .overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: 0;
        z-index: 1030;
        opacity: 0;
        transition: all 0.3s ease-in-out;
        pointer-events: none;
    }

    input.color-selector-toggle[type=checkbox]:checked + .overlay {
        pointer-events: auto;
        opacity: 1;
    }

    .color-selector {
        background-color: white;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }
</style>