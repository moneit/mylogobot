<template>
    <modal-overlay
            :id="id"
            :open="open"
            @update-open="updateOpen"
    >
        <div class="good-logo-modal">
            <div class="good-logos">
                <img :src="imgPath" />
            </div>
        </div>
    </modal-overlay>
</template>

<script>
    import ModalMixin from '../mixins/Modal.js';

    export default {
        name: "ErrorMessageModal",
        mixins: [ModalMixin],
        props: {
            imgPath: {
                type: String,
                required: true,
            }
        },
    }
</script>

<style scoped>
    .good-logos img {
        width: 50vw;
        min-width: 300px;
    }
</style>