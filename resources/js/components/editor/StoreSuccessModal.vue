<template>
    <modal-overlay
            :id="id"
            :open="open"
            @update-open="updateOpen"
    >
        <div class="store-success-modal container-fluid">
            <div class="row">
                <i class="logobot-icon icon-check color-secondary m-auto" style="font-size: 6rem;"></i>
            </div>
            <div class="row d-block color-secondary" style="font-size: 2rem;">
                Artwork Saved
            </div>
            <div class="row">
                <p>
                    Your logo is saved to My Account and you can review it later
                </p>
            </div>
            <div class="row">
                <div class="col-6">
                    <a href="/my-account" class="w-100 h-100 btn btn-outline-dark">
                        My Account
                    </a>
                </div>
                <div class="col-6">
                    <label :for="id" class="w-100 h-100 btn btn-theme gradient-secondary-90">
                        Keep Editing
                    </label>
                </div>
            </div>
        </div>
    </modal-overlay>
</template>

<script>
    import ModalMixin from '../../mixins/Modal.js';

    export default {
        name: "StoreSuccessModal",
        mixins: [ModalMixin],
    }
</script>

<style scoped>
    .store-success-modal {
        width: 324px;
    }
</style>