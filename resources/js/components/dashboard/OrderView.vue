<template>
    <div class="row flex-fill">
        <div class="col-md-12 mb-4">
            <router-link :to="{ name: 'orders' }" class="btn btn-ghost">
                <i class="logobot-icon icon-angle-left"></i>&nbsp;&nbsp;&nbsp;back
            </router-link>
        </div>
        <template v-if="order.id">
            <div class="col-md-2">
                <div class="logo-container">
                    <div class="logo" v-html="order.logo.svg"></div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row mb-4 color-primary">
                    Order Details
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="color-grey-light">Order Number</div>
                        <div class="color-grey">{{ order.id }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="color-grey-light">Date</div>
                        <div class="color-grey">{{ order.created_at }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="color-grey-light">Package</div>
                        <div class="color-grey">{{ order.package.name }}</div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row mb-4 color-primary">
                    User Details
                </div>
                <div class="row mb-4 divider"></div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="color-grey-light">User Name</div>
                        <div class="color-grey">{{ order.user.name }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="color-grey-light">E-Mail</div>
                        <div class="color-grey">{{ order.user.email }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="color-grey-light">Country</div>
                        <div class="color-grey">{{ order.country.name }}</div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="color-grey-light">Address</div>
                        <div class="color-grey">{{ order.address }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="color-grey-light">City</div>
                        <div class="color-grey">{{ order.city }}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="color-grey-light">State</div>
                        <div class="color-grey">{{ order.state }}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="color-grey-light">Zipcode</div>
                        <div class="color-grey">{{ order.zipcode }}</div>
                    </div>
                    <div class="col-md-2">
                        <div class="color-grey-light">Vat number</div>
                        <div class="color-grey">{{ order.vat_number }}</div>
                    </div>
                </div>
                <div class="row mb-4 divider"></div>
                <div class="row mb-4 color-primary">
                    Payment Details
                </div>
                <div class="row mb-4">
                    <div class="col-md-2">
                        <div class="color-grey-light">Status</div>
                        <div class="color-grey">{{ order.status }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="color-grey-light">Charge ID</div>
                        <div class="color-grey">{{ order.charge_id }}</div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="color-grey-light">Amount</div>
                        <div class="color-grey">{{ order.price }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="color-grey-light">Method</div>
                        <div class="color-grey">{{ order.payment_method }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="color-grey-light">Card number</div>
                        <div class="color-grey">{{ order.card }}</div>
                    </div>
                </div>
                <div class="row mb-4 divider"></div>
                <div class="row mb-4 justify-content-end">
                    <button class="btn btn-theme btn-ghost mr-3" @click="resend">Resend Files</button>
                    <button class="btn btn-theme btn-ghost mr-3" @click="download">Download Files</button>
                    <button class="btn btn-theme btn-ghost mr-3" disabled>Send Invoice</button>
                </div>
            </div>
        </template>

        <error-message-modal
                :open="showErrorMessageModal"
                :message="errorMessage"
                @update-open="updateShowErrorMessageModal"
        ></error-message-modal>
    </div>
</template>

<script>
    import ordersApi from '../../services/api/order.js';
    import ErrorMessageModal from '../ErrorMessageModal.vue';

    export default {
        name: "OrderView",
        components: {
            ErrorMessageModal
        },
        data() {
            return {
                order: {},
                showErrorMessageModal: false,
                errorMessage: '',
            }
        },
        mounted() {
            this.getOrderDetails();
        },
        methods: {
            getOrderDetails() {
                ordersApi.getOrder(this.$route.params)
                    .then(( data ) => {
                        if (data.status === 'success') {
                            this.order = data.payload;

                            return data.payload;
                        }
                    })
            },
            download() {
                this.$store.dispatch('product/downloadFromOrder', { orderId: this.order.id })
                    .then((res) => {
                        if (res.status === 'success') {
                            if (res.payload.downloadLink) {
                                window.location.href = res.payload.downloadLink;
                            } else if (res.payload.message) {
                                // show message
                                this.message = res.payload.message;
                                // todo : show success modal
                                this.updateShowErrorMessageModal(true);
                            }
                        } else {
                            this.message = res.payload.message;
                            this.updateShowErrorMessageModal(true);
                        }
                    });
            },
            resend() {
                this.$store.dispatch('product/resend', { orderId: this.order.id })
                    .then((res) => {
                        if (res.status === 'success') {
                            if (res.payload.downloadLink) {
                                window.location.href = res.payload.downloadLink;
                            } else if (res.payload.message) {
                                this.showErrorMessage(res.payload.message);// todo: show success modal
                            }
                        } else {
                            this.showErrorMessage(res.payload.message);
                        }
                    });
            },
            showErrorMessage(message) {
                this.errorMessage = message;
                this.updateShowErrorMessageModal(true);
            },
            updateShowErrorMessageModal(value) {
                this.showErrorMessageModal = value;
            },
        }
    }
</script>

<style scoped>
    .divider {
        border-bottom: 1px solid #DEE1E3;
    }
</style>