<template>
    <div id='checkout' class='row rounded shadow checkout'>

        <div class='fill-half p-3 w-100'>

            <div class='order-info shadow rounded mb-3'>

                <label class='col-12 mb-3 color-primary'>
                    Your order
                </label>

                <div class='col-12 mb-2'>
                    <div class='d-flex justify-content-between mb-1'>
                        <span class='text-capitalize'>{{ packageName }} Package</span>
                        <span v-if='amount'>${{ amount }}</span>
                    </div>

                    <div v-if='packageName === "premium"' style='font-size: 0.9em;'>
                        <div>Hi Resolution PNG & JPG</div>
                        <div>Vector Files (EPS, PDF, SVG)</div>
                        <div>Font Pairing</div>
                    </div>

                    <div v-if='packageName === "enterprise"' style='font-size: 0.9em;'>
                        <div>Hi Resolution PNG & JPG</div>
                        <div>Vector Files (EPS, PDF, SVG)</div>
                        <div>Font Pairing</div>
                        <div>Brand Guide</div>
                        <div>Social Media Pack</div>
                    </div>
                </div>

                <div class='col-12 mb-2 d-flex justify-content-between'>
                    <span>Vat ({{ vatRate * 100 }}%)</span>
                    <span v-if='vatPrice'>${{ vatPrice }}</span>
                </div>

                <div v-if='couponApplied' class='col-12 mb-2 d-flex justify-content-between align-items-center'>
                    <div>Coupon: {{ appliedCouponCode }}</div>
                    <div class='text-right' style='font-size: 0.9em;'>
                        <div>-${{ couponDiscount }}</div>
                        <div class='color-primary pointer' @click='removeCoupon'>[Remove]</div>
                    </div>
                </div>

                <div class='col-12 mb-2 font-weight-bold d-flex justify-content-between'>
                    <span>Total</span>
                    <span v-if='total'>${{ totalWithCoupon }}</span>
                </div>
            </div>
        </div>

        <div class='logo-info p-3 mb-3'>

            <label class='col-12 mb-3 color-primary'>
                Your logo
            </label>

            <div class='col-12'>
                <div v-if='svg'
                     class='shadow rounded svg-container'
                     v-html='svg'
                ></div>
            </div>
        </div>

        <form class='col-12' id='payment-form' :data-amount='amountInCents'>

            <transition-group name="slide-left">
                <div class='step p-3' v-show="step === 1" key="step-1">

                    <div class='checkout-info'>

                        <div class='billing-info row mb-3'>

                            <label class='col-12 mb-3 color-primary d-flex align-items-center'>
                                <div class="circle-step-container">
                                    <div class="position-absolute w-100 h-100">
                                        <div class="pie-wrapper step-1">
                                            <div class="shadow"></div>
                                            <div class="pie">
                                                <div class="left-side half-circle border-primary"></div>
                                                <div class="right-side half-circle border-primary"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-absolute w-100 h-100 text-center" style="line-height:2rem;font-size:1.5rem;">
                                        1
                                    </div>
                                </div>
                                <span>Billing Information</span>
                            </label>

                            <form-input class='col-md-12' field='address' label='Address' type='text' v-model='address'></form-input>

                            <form-input class='col-md-6' field='city' label='City' type='text' v-model='city'></form-input>

                            <form-input class='col-md-6' field='state' label='State / Region / Province' type='text' v-model='state'></form-input>

                            <country-selector class="col-md-6" v-model="country" :code='countryCode' @update-code='updateCountryCode'></country-selector>

                            <form-input class='col-md-6' field='zipcode' label='Zip Code' type='number' v-model='zipcode' data-vat='postal-code'></form-input>

                            <form-input class='col-md-6' field='vat' label='Vat Number' type='text' v-model='vat' data-vat='vat-number'></form-input>
                        </div>

                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6">
                                <span class="w-100 btn btn-theme background-primary pointer" @click="nextStep">
                                    Next Step
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='step p-3' v-show="step === 2" key="step-2">
                    <div class='checkout-info'>
                        <div class='payment-method row mb-3'>

                            <label class='col-12 mb-3 color-primary d-flex align-items-center'>
                                <div class="circle-step-container">
                                    <div class="position-absolute w-100 h-100">
                                        <div class="pie-wrapper step-2">
                                            <div class="shadow"></div>
                                            <div class="pie">
                                                <div class="left-side half-circle border-primary"></div>
                                                <div class="right-side half-circle border-primary"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-absolute w-100 h-100 text-center" style="line-height:2rem;font-size:1.5rem;">
                                        2
                                    </div>
                                </div>
                                <span>Payment Method</span>
                            </label>

                            <div class='col-6 offset-3 py-3'>
                                <div class='row'>
                                    <div class='col-md-4 input-group payment-method'>
                                        <input id='credit_card'
                                               class='payment-method-selector'
                                               type='radio'
                                               name='payment_method'
                                               value='credit_card'
                                               v-model='paymentMethod' />
                                        <label for='credit_card'></label>
                                        <label for='credit_card' class='name'>Credit Card</label>
                                    </div>

                                    <div class='col-md-4 input-group payment-method' style='visibility: hidden;'>
                                        <input id='paypal'
                                               class='payment-method-selector'
                                               type='radio'
                                               name='payment_method'
                                               value='paypal'
                                               v-model='paymentMethod' />
                                        <label for='paypal'></label>
                                        <label for='paypal' class='name'>Paypal</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <span class="w-100 btn btn-theme color-primary pointer" @click="previousStep">
                                    Previous Step
                                </span>
                            </div>
                            <div class="col-6">
                                <span class="w-100 btn btn-theme background-primary pointer" @click="nextStep">
                                    Next Step
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='step p-3' v-show="step === 3" key="step-3">
                    <div class='checkout-info'>
                        <div v-show='paymentMethod === "credit_card"' class='credit-card-info row mb-3 position-relative'>

                            <label class='col-12 mb-3 color-primary d-flex align-items-center'>
                                <div class="circle-step-container">
                                    <div class="position-absolute w-100 h-100">
                                        <div class="pie-wrapper step-3">
                                            <div class="shadow"></div>
                                            <div class="pie">
                                                <div class="left-side half-circle border-primary"></div>
                                                <div class="right-side half-circle border-primary"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-absolute w-100 h-100 text-center" style="line-height:2rem;font-size:1.5rem;">
                                        3
                                    </div>
                                </div>
                                <span>Credit Card Information</span>
                            </label>

                            <div class="col-12 text-center mb-3">
                                <img class='credit-cards' src='/img/creditcards.png' />
                            </div>

                            <div class='col-md-6'>
                                <div class='input-theme-stripe form-group'>
                                    <div id='card-number' class='input-theme'></div>
                                    <label for='card-number'>Card Number</label>
                                    <div class='invalid-feedback'>
                                        {{ cardNumberError }}
                                    </div>
                                </div>
                            </div>

                            <div class='col-md-3'>
                                <div class='input-theme-stripe form-group'>
                                    <div id='card-expiry' class='input-theme'></div>
                                    <label for='card-expiry'>MM/YY</label>
                                    <div class='invalid-feedback'>
                                        {{ cardExpiryError }}
                                    </div>
                                </div>
                            </div>

                            <div class='col-md-3'>
                                <div class='input-theme-stripe form-group'>
                                    <div id='card-cvc' class='input-theme'></div>
                                    <label for='card-cvc'>CVC</label>
                                    <div class='invalid-feedback'>
                                        {{ cardCvcError }}
                                    </div>
                                </div>
                            </div>

                            <form-input class='col-md-12' field='name' label='Card Holder Name' type='text' v-model='name'></form-input>
                        </div>
                        <div v-show='paymentMethod === "paypal"' class='paypal-info row mb-3 position-relative'></div>

                        <div class="row">
                            <div class="col-6">
                                <span class="w-100 btn btn-theme color-primary pointer" @click="previousStep">
                                    Previous Step
                                </span>
                            </div>
                            <div class="col-6">
                                <button type='submit' class="w-100 btn btn-theme background-secondary pointer">
                                    Purchase
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition-group>

            <div class='row'>
                <div class='col-md-8'>

                </div>
                <div class='col-md-4'>

                    <div class='row mb-3'>
                        <div class='col-12 mb-2 text-center'>
                            I have a <span class='coupon_code' @click='showCoupon = !showCoupon'>coupon code</span>
                        </div>

                        <div v-if='showCoupon' class='mb-2 col-8'>
                            <form-input field='coupon_code' label='Coupon Code' type='text' v-model='couponCode'></form-input>
                        </div>
                        <div v-if='showCoupon' class='mb-2 col-4'>
                            <div class='input-theme color-primary border-primary pointer' @click='applyCoupon'>Apply</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <payment-failure-modal
                :open='showPaymentFailureModal'
                :message='paymentFailureModalMessage'
                @update-open='updateShowPaymentFailureModal'
        ></payment-failure-modal>
    </div>
</template>

<script>
    const Checkout = Vue.component('checkout', require('./Checkout.vue').default);

    const CheckoutMobile = Checkout.extend({
        name: "CheckoutMobile",
        data() {
            return {
                step: 1,
            }
        },
        methods: {
            nextStep() {
                this.step++;
            },
            previousStep() {
                this.step--;
            }
        }
    });

    export default CheckoutMobile;
</script>

<style scoped lang='scss'>
    .order-info {
        background-color: white;
        padding: 1rem;

        label {
            display: block;
        }
    }
    label {
        display: inline;
    }
    .payment-method .name {
        cursor: pointer;
        margin: 0 0.5rem;
    }
    input[type=radio] {
        display: none;
    }
    input[type=radio] + label {
        cursor: pointer;
        background-color: #fafafa;
        border: 2px solid #cacece;
        border-radius: 50px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), 0 -15px 10px -12px rgba(0, 0, 0, 0.05) inset;
        display: inline-block;
        padding: 11px;
        position: relative;

    }
    input[type=radio] + label:before {
        background: none repeat scroll 0 0 #FDFDFD;
        border-radius: 50px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3) inset;
        content: ' ';
        font-size: 36px;
        height: 8px;
        left: 7px;
        position: absolute;
        top: 7px;
        width: 8px;
    }
    input[type=radio]:checked + label:after {
        background: none repeat scroll 0 0 #94E325;
        border-radius: 50px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3) inset;
        content: ' ';
        font-size: 36px;
        height: 8px;
        left: 7px;
        position: absolute;
        top: 7px;
        width: 8px;
    }
    input[type=radio]:checked + label {
        border: 2px solid #adb8c0;
        color: #99a1a7;
        padding: 11px;
    }
    input[type=radio] + label:active, input[type=radio]:checked + label:active {
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1) inset;
    }

    .coupon_code {
        cursor: pointer;
        text-decoration: underline;
    }
    .invalid label {
        color: #dc3545;
    }

    .circle-step-container {
        position: relative;
        display: inline-block;
        width:2rem;
        padding-bottom:2rem;
        font-size:2rem;
        margin-right:1rem;

        .pie-wrapper {
            height: 1em;
            width: 1em;
            float: left;
            position: relative;

            .shadow {
                height: 100%;
                width: 100%;
                border: 0.1em solid #bdc3c7;
                border-radius: 50%;
            }

            .pie {
                height: 100%;
                width: 100%;
                clip: rect(auto, auto, auto, auto);
                left: 0;
                position: absolute;
                top: 0;

                .half-circle {
                    height: 100%;
                    width: 100%;
                    border: 0.1em solid #3498db;
                    border-radius: 50%;
                    clip: rect(0, 0.5em, 1em, 0);
                    left: 0;
                    position: absolute;
                    top: 0;
                }
            }

            &.step-1 {
                .pie {
                    clip: rect(0, 1em, 1em, 0.5em);

                    .left-side {
                        -webkit-transform: rotate(120deg);
                        transform: rotate(120deg);
                    }
                    .right-side {
                        display: none;
                    }
                }
            }

            &.step-2 {
                .pie {
                    .left-side {
                        -webkit-transform: rotate(240deg);
                        transform: rotate(240deg);
                    }
                    .right-side {
                        -webkit-transform: rotate(180deg);
                        transform: rotate(180deg);
                    }
                }
            }

            &.step-3 {
                .pie {
                    .left-side {
                        -webkit-transform: rotate(360deg);
                        transform: rotate(360deg);
                    }
                    .right-side {
                        -webkit-transform: rotate(180deg);
                        transform: rotate(180deg);
                    }
                }
            }
        }
    }
</style>
<style>
    .svg-container svg {
        width: 100%;
        height: 100%;
    }
</style>