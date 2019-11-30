<template>
    <div>
        <div class="row d-flex text-center">
            <div class="type-tab mb-3"
                 v-for="type in types"
                 :class="{'active color-secondary': type.selected}"
                 :key="type.label"
                 @click="updateValue(type)"
            >
                <i :class="type.icon"></i>
                {{ type.label }}
            </div>
        </div>
        <div v-for="type in types"
             :key="type.label"
             v-if="type.selected">
            <slot :name="type.label"></slot>
        </div>
    </div>
</template>

<script>
    import LogoAdjustment from '../../mixins/LogoAdjustment.js';

    export default {
        name: "TypeSelector",
        props: {
            'field': {
                default: 'type'
            }
        },
        mixins: [LogoAdjustment],
        data() {
            return {
            }
        },
        computed: {
            types() {
                return this.$store.state[this.storeModule].types;
            }
        },
    }
</script>

<style scoped>
    .type-tab {
        flex: 1;
        padding: 0 1rem 0.75rem;
        cursor: pointer;
        border-bottom: 0.25rem solid;
        color: #ACB4B9;
    }
    .type-tab:not(.active) {
        border-color: #DEE1E3;
    }
</style>