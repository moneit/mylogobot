<template>
    <div class="modal-overlay">
        <input :id="id" class="modal-toggle" type="checkbox" v-model="modalOpen">
        <label :for="id" class="overlay"></label>
        <div v-if="modalOpen" class="modal-wrapper">
            <div>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    import uid from '../../helpers/uniqueIdHelper.js';

    export default {
        name: "ModalOverlay",
        props: {
            id: {
                type: String,
                default: function() {
                    return uid.generate();
                }
            },
            open: {
                type: Boolean,
                default: function() {
                    return false;
                }
            }
        },
        computed: {
            modalOpen: {
                get() {
                    return this.open;
                },
                set(value) {
                    this.$emit('update-open', value);
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;

        .modal-toggle {
            display: none;

            & + .overlay {
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

            &[type=checkbox]:checked + .overlay {
                pointer-events: auto;
                opacity: 1;
            }
        }

        .modal-wrapper {
            position: fixed;
            z-index: 1030;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            text-align: center;
            -webkit-border-radius: 0.5rem;
            -moz-border-radius: 0.5rem;
            border-radius: 0.5rem;

            &::before {
                content: "";
                display: inline-block;
                height: 100%;
                vertical-align: middle;
            }

            > div {
                position: relative;
                display: inline-block;
                vertical-align: middle;
                background-color: white;
                padding: 1rem;
                border-radius: 0.25rem;
                pointer-events: auto;
            }
        }
    }
</style>