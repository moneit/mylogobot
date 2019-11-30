<template>
    <div class="button-modal">
        <label :for="id" :class="buttonClasses">{{ buttonLabel }}</label>
        <modal-overlay
                :id="id"
        ></modal-overlay>
    </div>
</template>

<script>
    import uid from '../../helpers/uniqueIdHelper.js';
    import ModalOverlay from './ModalOverlay.vue';

    export default {
        name: "ButtonModal",
        components: {
            ModalOverlay
        },
        props: {
            buttonLabel: {
                type: String,
                required: true,
            },
            buttonClasses: {
                default: function() {
                    return [];
                }
            }
        },
        data() {
            return {
                id: uid.generate(),
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>