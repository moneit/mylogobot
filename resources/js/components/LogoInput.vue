<template>
    <form-input
            :field="field"
            :label="label"
            v-model="value"
            @keyup="event => this.$emit('keyup', event)"
    ></form-input>
</template>

<script>
    import FormInput from './FormInput.vue';
    import LogoAdjustment from '../mixins/LogoAdjustment.js';

    export default {
        name: "LogoInput",
        props: ['label'],
        mixins: [LogoAdjustment],
        components: {FormInput},
    }
</script>

<style scoped>

</style>