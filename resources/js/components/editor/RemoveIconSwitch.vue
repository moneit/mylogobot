<template>
    <div class="d-flex">
        <input type="checkbox" id="remove-icon" class="switch-input" v-model="hidden">
        <label for="remove-icon" class="switch-label">Remove Icon</label>
    </div>
</template>

<script>
    export default {
        name: "RemoveIconSwitch",
        computed: {
            hidden: {
                get() {
                    return this.$store.state.symbol.hidden;
                },
                set(value) {
                    this.$store.dispatch('symbol/updateIconHidden', value);
                }
            },
        },
    }
</script>

<style scoped>
    .switch-input {
        display: none;
    }
    .switch-label {
        position: relative;
        display: inline-block;
        min-width: 112px;
        cursor: pointer;
        font-weight: 500;
        text-align: left;
        margin: 0;
        padding: 0 44px 0 0;
    }
    .switch-label:before, .switch-label:after {
        content: "";
        position: absolute;
        margin: 0;
        outline: 0;
        top: 50%;
        -ms-transform: translate(0, -50%);
        -webkit-transform: translate(0, -50%);
        transform: translate(0, -50%);
        -webkit-transition: all 0.3s ease;
        transition: all 0.3s ease;
    }
    .switch-label:before {
        right: 1px;
        width: 34px;
        height: 14px;
        background-color: #9E9E9E;
        border-radius: 8px;
    }
    .switch-label:after {
        right: 18px;
        width: 20px;
        height: 20px;
        background-color: #E0E0E0;
        border-radius: 50%;
        box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.14), 0 2px 2px 0 rgba(0, 0, 0, 0.098), 0 1px 5px 0 rgba(0, 0, 0, 0.084);
    }
    .switch-input:checked + .switch-label:before {
        background-color: #B2C3D4;
    }
    .switch-input:checked + .switch-label:after {
        background-color: #1D1E7A;
        -ms-transform: translate(80%, -50%);
        -webkit-transform: translate(80%, -50%);
        transform: translate(80%, -50%);
    }
</style>