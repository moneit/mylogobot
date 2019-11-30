<template>
    <modal-overlay
            :id="id"
            :open="open"
            @update-open="updateOpen"
    >
        <div class="store-success-modal container-fluid">
            <div class="row">
                <i class="logobot-icon icon-times-circle m-auto" style="font-size: 6rem;color: #EB5757;"></i>
            </div>
            <div class="row d-block" style="font-size: 2rem;color: #EB5757;">
                Error
            </div>
            <div class="row">
                <p class="col-12 text-secondary">
                    {{ message }}
                </p>
            </div>
            <div class="row">
                <div class="col-12">
                    <label :for="id" class="w-100 h-100 btn btn-outline-secondary">
                        Go back and try again
                    </label>
                </div>
            </div>
        </div>
    </modal-overlay>
</template>

<script>
    import ModalMixin from '../../mixins/Modal.js';

    export default {
        name: "PaymentFailureModal",
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
    .store-success-modal {
        width: 324px;
    }
</style>