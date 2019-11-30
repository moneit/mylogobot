<template>
    <div id='checkout' class='row rounded shadow checkout'>
        <form class='col-12' id='payment-form' :data-amount = 'amountInCents'>
            <div class='row'>
                <div class='col-md-8'>
                    <div class='checkout-info'>

                        <div class='billing-info row mb-3'>

                            <label class='col-12 mb-3 color-primary'>
                                Billing Information
                            </label>

                            <form-input class='col-md-12' field='address' label='Address' type='text' v-model='address'></form-input>

                            <form-input class='col-md-6' field='city' label='City' type='text' v-model='city'></form-input>

                            <form-input class='col-md-6' field='state' label='State / Region / Province' type='text' v-model='state'></form-input>

                            <country-selector class="col-md-6" v-model="country" :code='countryCode' @update-code='updateCountryCode'></country-selector>

                            <form-input class='col-md-6' field='zipcode' label='Zip Code' type='text' v-model='zipcode' data-vat='postal-code'></form-input>

                            <form-input class='col-md-6' field='vat' label='Vat Number' type='text' v-model='vat' data-vat='vat-number'></form-input>
                        </div>

                        <div class='payment-method row mb-3'>

                            <label class='col-12 mb-3 color-primary'>
                                Payment Method
                            </label>

                            <div class='col-12'>
                                <div class='row'>
                                    <div class='col-6 col-md-4 input-group payment-method'>
                                        <input id='paypal'
                                               class='payment-method-selector'
                                               type='radio'
                                               name='payment_method'
                                               value='paypal'
                                               v-model='paymentMethod' />
                                        <label for='paypal'></label>
                                        <label for='paypal' class='name'>Paypal</label>
                                    </div>

                                    <div class='col-6 col-md-4 input-group payment-method'>
                                        <input id='credit_card'
                                               class='payment-method-selector'
                                               type='radio'
                                               name='payment_method'
                                               value='credit_card'
                                               v-model='paymentMethod' />
                                        <label for='credit_card'></label>
                                        <label for='credit_card' class='name'>Credit Card</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-show='paymentMethod === "credit_card"' class='credit-card-info row mb-3 position-relative'>

                            <label class='col-12 mb-3 color-primary'>
                                Credit Card Information
                            </label>

                            <img class='credit-cards' src='/img/creditcards.png' />

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
                        <div v-show='paymentMethod === "paypal"' class='paypal-info row mb-3 position-relative'>
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
                <div class='col-md-4'>
                    <div class='logo-info row mb-3'>

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

                    <div class='order-info row mb-3'>

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

                        <div class='col-12 text-center'>
                            <button type='submit' class='btn btn-theme color-white gradient-secondary-90 input-theme shadow-none w-50' v-show='paymentMethod === "credit_card"'>
                                Purchase
                            </button>
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
  import FormInput from '../FormInput.vue';
  import CountrySelector from '../CountrySelector.vue';
  import lsHelper from '../../helpers/localStorageHelper.js';
  import uniqueIdHelper from '../../helpers/uniqueIdHelper.js';
  import logoApi from '../../services/api/logo.js';
  import packagesApi from '../../services/api/packages.js';
  import accountApi from '../../services/api/account.js';
  import paymentApi from '../../services/api/payment.js';
  import couponApi from '../../services/api/coupon.js';
  import orderApi from '../../services/api/order.js';
  import vatApi from '../../services/api/vat.js';
  import PaymentFailureModal from './PaymentFailureModal.vue';
  import * as _ from 'lodash';

  export default {
    name: 'Checkout',
    components: {
      FormInput,
      CountrySelector,
      PaymentFailureModal,
    },
    props: {
      pk: {
        required: true
      }
    },
    data() {
      return {
        downloadSettings: lsHelper.get('downloadSettings'),
        paymentMethod: 'credit_card',

        uuid: uniqueIdHelper.generate(),

        // address: ''
        cardNumberError: '',
        cardExpiryError: '',
        cardCvcError: '',
        name: '',

        svg: '',

        address: '',
        city: '',
        zipcode: '',
        state: '',
        vat: '',

        country: '',
        countryCode: '',

        packageName: '',
        amount: 0,
        vatRate: '',
        vatPrice: '',
        total: '',

        showCoupon: false,
        couponCode: '',
        appliedCouponCode: '',
        couponDiscount: 0,
        couponApplied: false,

        orderId: null, // my back-end
        nonePaymentOrderId: null,

        showPaymentFailureModal: false,
        paymentFailureModalMessage: '',
      }
    },

    computed: {
      amountInCents() {
        return this.amount * 100;
      },
      totalWithCoupon() {
        return (this.total - this.couponDiscount).toFixed(2);
      }
    },

    mounted() {
      if (this.downloadSettings && this.downloadSettings.logoId) {
        if (this.downloadSettings.packageId) {
          Promise.all([
            logoApi.get({
              id: this.downloadSettings.logoId
            }, res => {
              if (res.status === 'success' && res.payload.length === 1) {
                this.svg = res.payload[0].svg;
              }
            }),

            packagesApi.get({
              id: this.downloadSettings.packageId
            }, res => {
              if (res.status === 'success' && res.payload.length === 1) {
                this.amount = res.payload[0].price;
                this.packageName = res.payload[0].name;
              }
            }),

            accountApi.get({
              // nothing
            }, res => {
              if (res.status === 'success') {
                this.address = res.payload.address;
                this.city = res.payload.city;
                this.zipcode = res.payload.postal_code;
                this.state = res.payload.state;
                this.vat = res.payload.vat;
                this.country = res.payload.country.name;
                this.countryCode = res.payload.country.code;
              }
            }),
          ]).then((values) => {
            this.calculate();
          });
        } else {
          window.location.href = window.location.origin + '/packages'; // go to packages page
        }
      } else {
        window.location.href = window.location.origin + '/editor'; // go to editor page
      }

      this.createStripeElements();

      const recursiveCheck = function () { // endless paypal polling
        return new Promise(function(resolve, reject) {
          setTimeout(function() {
            if (paypal) {
              resolve(paypal);
            } else { // recursively require paypal
              resolve(recursiveCheck());
            }
          }, 1000);
        });
      };

      recursiveCheck().then(pp => {
        this.renderPayPalButton(pp);
      });
    },
    methods: {
      paymentSuccessCallback(orderId) {
        fbq('track', 'Purchase', {
          value: this.total.toFixed(2),
          currency: '$',
          contents: [
            {
              id: this.downloadSettings.logoId,
              quantity: 1
            }
          ],
        });
        lsHelper.remove('downloadSettings');
        //this.goToReceiptPage(orderId);
      },
      paymentFailureCallback(error) {
        // Stop loading!
        this.$store.dispatch('payment/markPaymentCompleted');
        // checkout.classList.remove('submitting');
        // Inform the user if there was an error
        if (typeof error === 'object' && error.message) {
          this.paymentFailureModalMessage = error.message;
        } else {
          this.paymentFailureModalMessage = error;
        }
        this.showPaymentFailureModal = true;
      },
      renderPayPalButton(payPal) {
        payPal.Buttons({
          createOrder: (data, actions) => {

            // Show a loading screen...
            this.$store.dispatch('payment/markPaymentInProgress');
            // checkout.classList.add('submitting');

            // Set up the transaction
            return paymentApi.intent({
              paymentMethod: this.paymentMethod, // 'paypal' or 'credit_card'
              address: this.address,
              city: this.city,
              zipcode: this.zipcode,
              state: this.state,
              vat: this.vat,
              packageId: this.downloadSettings.packageId,
              logoId: this.downloadSettings.logoId,
              countryCode: this.countryCode,
              totalPrice: this.total.toFixed(2),
              couponCode: this.couponCode,
              totalWithCoupon: this.totalWithCoupon,
              idempotencyKey: this.uuid
            }).then(res => {
              if (res.status === 'success') {
                this.orderId = res.payload.orderId;

                return actions.order.create({
                  purchase_units: [{
                    amount: {
                      value: this.totalWithCoupon
                    }
                  }]
                });
              } else {
                this.paymentFailureCallback(res.payload.message);
              }
            });
          },
          onCancel: (data) => {
            // Stop loading!
            this.$store.dispatch('payment/markPaymentCompleted');
          },
          onApprove: (data, actions) => {
            // Capture the funds from the transaction
            return actions.order.capture().then((details) => {
              // Show a success message to your buyer
              alert('Transaction completed by ' + details.payer.name.given_name);
              if (details.error = 'INSTRUMENT_DECLINED') {
                return actions.restart();
              }

              // Call your server to save the transaction
              return paymentApi.verifyPaypalTransaction({
                orderId: this.orderId,
                paypalOrderId: data.orderID
              }).then(res => {
                if (res.status === 'success') {
                  this.paymentSuccessCallback(this.orderId);
                }
              });
            });
          }
        }).render('#paypal-button-container');
      },
      createStripeElements() {
        let stripe = Stripe(this.pk);

        let elements = stripe.elements({
          fonts: [
            {
              cssSrc: 'https://fonts.googleapis.com/css?family=Source+Code+Pro',
            },
          ],
          locale: 'auto'
        });

        let elementStyles = {
          base: {
            iconColor: '#666EE8',
            color: '#212529', // same with body color in common.scss
            fontWeight: 400, // default font weight
            fontFamily: 'Montserrat, sans-serif', // same with body font family in common.scss
            fontSize: '16px',
            fontSmoothing: 'antialiased',

            '::placeholder': {
              color: 'transparent',
            },
            ':-webkit-autofill': {
              color: '#e39f48',
            },
          },
          invalid: {
            color: '#dc3545',

            '::placeholder': {
              color: 'transparent',
            },
            ':-webkit-autofill': {
              color: '#dc3545',
            },
          },
        };

        let elementClasses = {
          focus: 'focused',
          empty: 'empty',
          invalid: 'invalid',
        };

        let cardNumber = elements.create('cardNumber', {
          style: elementStyles,
          classes: elementClasses,
        });
        cardNumber.mount('#card-number');

        let cardExpiry = elements.create('cardExpiry', {
          style: elementStyles,
          classes: elementClasses,
        });
        cardExpiry.mount('#card-expiry');

        let cardCvc = elements.create('cardCvc', {
          style: elementStyles,
          classes: elementClasses,
        });
        cardCvc.mount('#card-cvc');

        this.registerStripeElements(stripe, {cardNumber, cardExpiry, cardCvc});
      },
      createNonPaymentOrder() {
        return orderApi.createOrder({
          packageId: this.downloadSettings.packageId,
          logoId: this.downloadSettings.logoId,
          countryCode: this.countryCode,
        });
      },
      registerStripeElements(stripe, elements) {
        let checkout = document.querySelector('.checkout');

        let form = checkout.querySelector('form');

        function enableInputs() {
          Array.prototype.forEach.call(
            form.querySelectorAll(
              'input[type="text"], input[type="email"], input[type="tel"]'
            ),
            function(input) {
              input.removeAttribute('disabled');
            }
          );
        }

        function disableInputs() {
          Array.prototype.forEach.call(
            form.querySelectorAll(
              'input[type="text"], input[type="email"], input[type="tel"]'
            ),
            function(input) {
              input.setAttribute('disabled', 'true');
            }
          );
        }

        function triggerBrowserValidation() {
          // The only way to trigger HTML5 form validation UI is to fake a user submit event.
          let submit = document.createElement('input');
          submit.type = 'submit';
          submit.style.display = 'none';
          form.appendChild(submit);
          submit.click();
          submit.remove();
        }

        // Listen for errors from each Element, and show error messages in the UI.
        let savedErrors = {};
        for(let elementKey in elements) {
          if (elements.hasOwnProperty(elementKey)) {
            elements[elementKey].on('change', (event) => {
              if (event.error) {
                if (event.elementType) {
                  switch(event.elementType) {
                    case 'cardNumber':
                      this.cardNumberError = event.error.message;
                      break;
                    case 'cardExpiry':
                      this.cardExpiryError = event.error.message;
                      break;
                    case 'cardCvc':
                      this.cardCvcError = event.error.message;
                  }
                }
              } else {
                if (event.elementType) {
                  switch(event.elementType) {
                    case 'cardNumber':
                      this.cardNumberError = '';
                      break;
                    case 'cardExpiry':
                      this.cardExpiryError = '';
                      break;
                    case 'cardCvc':
                      this.cardCvcError = '';
                  }
                }
              }
            });
          }
        }

        // Listen on the form's 'submit' handler...
        form.addEventListener('submit', (e) => {
          if (this.paymentMethod === 'credit_card') {
            e.preventDefault();

            if (this.totalWithCoupon === "0.00") {
              const downloadFromOrderId = (orderId) => {
                this.$store.dispatch('product/downloadFromOrder', { orderId })
                  .then((res) => {
                    if (res.status === 'success') {
                      if (res.payload.downloadLink) {
                        window.location.href = res.payload.downloadLink;
                      } else if (res.payload.message) {
                        this.paymentFailureModalMessage = res.payload.message;
                        this.showPaymentFailureModal = true;
                      }
                    } else {
                      this.paymentFailureModalMessage = res.payload.message;
                      this.showPaymentFailureModal = true;
                    }
                  });
              };

              if (this.nonePaymentOrderId) {
                downloadFromOrderId(this.nonePaymentOrderId);
              } else {
                this.createNonPaymentOrder()
                  .then(res => {
                    if (res.status === 'success') {
                      this.nonePaymentOrderId = res.payload.order.id;

                      downloadFromOrderId(this.nonePaymentOrderId);
                    }
                  });
              }

              return;
            }

            // Trigger HTML5 validation UI on the form if any of the inputs fail
            // validation.
            let plainInputsValid = true;
            Array.prototype.forEach.call(form.querySelectorAll('input'), function(
              input
            ) {
              if (input.checkValidity && !input.checkValidity()) {
                plainInputsValid = false;
                return;
              }
            });
            if (!plainInputsValid) {
              triggerBrowserValidation();
              return;
            }

            // Show a loading screen...
            this.$store.dispatch('payment/markPaymentInProgress');
            // checkout.classList.add('submitting');

            // Disable all inputs.
            disableInputs();

            // Gather additional customer data we may have collected in our form.
            let billing_details = {
              name: this.name ? this.name : undefined,
              address: {
                city: this.city ? this.city : undefined,
                country: this.countryCode ? this.countryCode : undefined,
                line1: this.address ? this.address : undefined,
                postal_code: this.zipcode ? this.zipcode : undefined,
                state: this.state ? this.state : undefined,
              }
            };

            const paymentSuccessCallback = this.paymentSuccessCallback;
            const paymentFailureCallback = (error) => {
              // Un-disable inputs.
              enableInputs();
              this.paymentFailureCallback(error);
            };

            stripe.createPaymentMethod('card', elements.cardNumber, { billing_details }).then((result) => {
              if (result.error) {
                paymentFailureCallback(result.error.message);
              } else {
                paymentApi.intent({
                  paymentMethodId: result.paymentMethod.id, // id from stripe.com
                  paymentMethod: this.paymentMethod, // 'paypal' or 'credit_card'
                  address: this.address,
                  city: this.city,
                  zipcode: this.zipcode,
                  state: this.state,
                  vat: this.vat,
                  packageId: this.downloadSettings.packageId,
                  logoId: this.downloadSettings.logoId,
                  countryCode: this.countryCode,
                  totalPrice: this.total.toFixed(2),
                  couponCode: this.couponCode,
                  totalWithCoupon: this.totalWithCoupon,
                  idempotencyKey: this.uuid
                }).then(res => {
                  if (res.status === 'success') {
                    if (res.payload.requiresAction === true) {
                      stripe.handleCardAction(res.payload.paymentIntent.client_secret).then(result => {
                        if (result.error) {
                          paymentFailureCallback(result.error);
                        } else {
                          // The card action has been handled
                          // The PaymentIntent can be confirmed again on the server
                          paymentApi.confirm({
                            paymentIntentId: result.paymentIntent.id, // id from stripe.com
                            orderId: res.payload.orderId
                          }).then(result => {
                            if (result.status === 'success') {
                              paymentSuccessCallback(res.payload.orderId);
                            } else {
                              paymentFailureCallback(result.payload.message);
                            }
                          }).catch((error) => {
                            paymentFailureCallback(error);
                          });
                        }
                      }).catch((error) => {
                        paymentFailureCallback(error);
                      });
                    } else {
                      paymentSuccessCallback(res.payload.orderId);
                    }
                  } else {
                    paymentFailureCallback(res.payload.message);
                  }
                }).catch((error) => {
                  paymentFailureCallback(error);
                });
              }
            }).catch((error) => {
              paymentFailureCallback(error);
            });
          }
        });
      },
      debouncedCalculate: _.debounce(VATCalculator.calculate, 1000),
      calculate() {
        return new Promise((resolve, reject) => {
          this.$nextTick(() => {
            this.debouncedCalculate((res) => {
              this.vatRate = res.tax_rate;
              this.vatPrice = res.tax_value.toFixed(2);
              this.total = res.gross_price;

              if (this.couponApplied) {
                this.applyCoupon();
              }

              if (resolve) {
                resolve();
              }
            });
          });
        });
      },
      updateCountryCode(code) {
        this.countryCode = code;
      },
      applyCoupon() {
        couponApi.apply({
          code: this.couponCode,
          total: this.total
        }, res => {
          if (res.status === 'success') {
            this.appliedCouponCode = res.payload.code;
            this.couponDiscount = res.payload.discount;
            this.couponApplied = true;
          } else {
            this.paymentFailureModalMessage = res.payload.message;
            this.showPaymentFailureModal = true;
          }
        }, err => {
          console.log(err);
        }).catch(err => {
          console.log('err', err);
        })
      },
      removeCoupon() {
        this.couponApplied = false;
        this.couponDiscount = 0;
      },
      updateShowPaymentFailureModal(value) {
        this.showPaymentFailureModal = value;
      },
      goToReceiptPage(orderId) {
        window.location.href = window.location.origin + '/order/' + orderId;
      },
    },
    watch: {
      zipcode(value, oldValue) {
        // if (oldValue) { // re-calculate when postal code changes
        this.calculate();
        // }
      },
      vat(value, oldValue) {
        // if (oldValue) { // re-calculate when vat changes
        this.calculate();
        // }
      },
      countryCode(value, oldValue) {
        // if (oldValue) { // re-calculate when country code changes
        this.calculate();
        // }
      },
    }
  }
</script>

<style scoped>
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

    .credit-cards {
        position: absolute;
        right: 15px;
    }
    .coupon_code {
        cursor: pointer;
        text-decoration: underline;
    }
    .invalid label {
        color: #dc3545;
    }
</style>
<style>
    .svg-container svg {
        width: 100%;
        height: 100%;
    }
</style>