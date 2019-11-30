<template>
    <div>
        <div class="form-group input-group">
            <input :id="id || field" class="input-theme"
                   :class="{'is-invalid': invalid, 'has-value': input}"
                   :name="field"
                   :type="type"
                   :placeholder="label"
                   :required="required"
                   :autofocus="autofocus"
                   autocomplete="off"
                   v-model="input"
                   @keyup="event => this.$emit('keyup', event)"
                   :data-vat="dataVat">
            <label :for="id || field">{{ label }}</label>
            <div class="invalid-feedback" v-if="invalid">
                {{ error }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FormInput",
        props: ["id", "field", "label", "type", "required", "error", "value", "autofocus", "dataVat"],
        data() {
            return {
                //
            }
        },
        computed: {
            input: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.$emit('input', value);
                },
            },
            invalid() {
                return this.error && this.input === this.value;
            }
        }
    }
</script>

<style scoped>
    input:focus {
        border: 1px solid #3E3FA0;
    }

    input::placeholder {
        color: transparent !important;
    }

    input:not(:placeholder-shown) {
        padding: 1.25rem 1.5rem 0.25rem;
    }

    label {
        position: absolute;
        top: 0;
        left: 0;
        margin: 0;
        padding: 0.75rem 1.5rem;
        color: #aaa;
        border: 3px solid transparent;
        pointer-events: none;
        transition: 0.2s ease all;
        -moz-transition: 0.2s ease all;
        -webkit-transition: 0.2s ease all;

        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        width: 100%;
    }

    input:not(:placeholder-shown) + label {
        font-size: 0.75rem;
        padding-top: 0.25rem
    }

    .invalid-feedback {
        display: block;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }

    /* Fallback for Edge */
    @supports (-ms-ime-align: auto) {
        label {
            display: none;
        }
        input::-ms-input-placeholder {
            color: #777;
        }
    }

    /* Fallback for IE */
    @media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
        label {
            display: none;
        }
        input:-ms-input-placeholder {
            color: #777;
        }
    }
</style>