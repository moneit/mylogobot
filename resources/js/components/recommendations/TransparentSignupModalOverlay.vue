<template>
    <div class="modal-overlay">
        <input :id="id" class="modal-toggle" type="checkbox" v-model="modalOpen">
        <label class="overlay"></label>
        <div v-if="modalOpen" class="modal-wrapper">
            <div>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
    const ModalOverlay = Vue.component('modal-overlay', require('../modals/ModalOverlay.vue').default);
    const QuickEdit = Vue.component('quick-edit', require('./QuickEdit.vue').default);

    const TransparentSignupModalOverlay = ModalOverlay.extend({
        name: "TransparentSignupModalOverlay",
        components: {
            QuickEdit
        }
    });

    export default TransparentSignupModalOverlay;
</script>

<style lang="scss" scoped>
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
        z-index: 1030;

        .modal-toggle {
            display: none;

            & + .overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                margin: 0;
                background: rgba(8, 8, 84, 0.5);
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
            position: absolute;
            z-index: 1030;
            left: 30px;
            right: 30px;
            top: 0;
            bottom: 0;
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
                border-radius: 0.25rem;
                pointer-events: auto;
            }
        }
    }
</style>