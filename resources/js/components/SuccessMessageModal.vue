<template>
    <modal-overlay
            :id="id"
            :open="open"
            @update-open="updateOpen"
    >
        <div class="information-modal container-fluid">
            <div class="row">
                <i class="logobot-icon icon-check color-secondary m-auto" style="font-size: 6rem;"></i>
            </div>
            <div class="row d-block color-secondary" style="font-size: 2rem;">
                Success
            </div>
            <div class="row">
                <p class="col-12 text-secondary">
                    {{ message }}
                </p>
            </div>
            <div class="row">
                <div class="col-12">
                    <label :for="id" class="w-100 h-100 btn btn-outline-secondary">
                        OK
                    </label>
                </div>
            </div>
        </div>
    </modal-overlay>
</template>

<script>
    import ModalMixin from '../mixins/Modal.js';

    export default {
        name: "SuccessMessageModal",
        mixins: [ModalMixin],
        props: {
            message: {
                type: String,
                required: true,
            }
        },
    }
</script>

<style scoped>
    .information-modal {
        width: 324px;
    }
</style>