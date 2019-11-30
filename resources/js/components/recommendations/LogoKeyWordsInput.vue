<template>
    <div>
        <div class="form-group input-group input-theme">
            <div :class="companyDetails ? 'has-tags' : ''">
                <span v-for="(keyword, idx) of companyDetails.split(' ')" v-if="keyword" class="keyword">
                    {{ keyword }}<i class="logobot-icon icon-times-circle pointer" @click="removeKeyword(idx)"></i>
                </span>
            </div>
            <input :id="id || field"
                   :class="{'is-invalid': invalid, 'has-value': input}"
                   :name="field"
                   :type="type"
                   :placeholder="label"
                   :required="required"
                   :autofocus="autofocus"
                   autocomplete="off"
                   v-model="input"
                   @keyup="onKeyUp">
            <label :for="id || field">{{ label }}</label>
            <div class="invalid-feedback" v-if="invalid">
                {{ error }}
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: "LogoKeyWordInput",
    props: ["id", "field", "label", "type", "required", "error", "value", "autofocus", "dataVat"],
    data() {
      return {
        input: this.value
      }
    },
    methods: {
      removeKeyword(index) {
        if (this.companyDetails) {
          let newKeyWords = this.companyDetails.split(' ').filter((k, i) => { return i !== index; }).join(' ');
          this.$store.dispatch('updateCompanyDetails', newKeyWords);
        }
      },
      toBlock(value) {
        let trimmedValue = value.trim();
        if (trimmedValue) {
          let keyWord = trimmedValue.replace(/\d|`|~|!|@|#|\$|%|\^|&|\*|\(|\)|-|_|\+|=|{|}|\[|]|:|;|"|'|\|\\|\/|\?|<|>|,|\./gi, '');

          let keyWords = this.companyDetails.split(' ');
          keyWords.push(keyWord);
          this.companyDetails = keyWords.join(' ');
        }

        this.input = this.input.substring(value.length);
      },
      onKeyUp(e) {
        let key = e.key || e.keyCode;
        if (key === " " || key === 32) { // space
          this.toBlock(this.input);
        }
        if (key === "Enter" || key === 13) { // enter
          this.toBlock(this.input.trim());
        }
        this.$emit('keyup', event)
      }
    },
    computed: {
      companyDetails: {
        get() {
          return this.$store.getters.companyDetails;
        },
        set(value) {
          this.$store.dispatch('updateCompanyDetails', value);
        }
      },
      invalid() {
        return this.error && this.input === this.value;
      }
    }
  }
</script>

<style scoped>
    .keyword {
        margin: 5px;
        line-height: 2;
        padding: 3px 10px;
        color: #3D3FA0;
        background: rgba(30, 30, 122, 0.16);
        border-radius: 50px;
    }

    .keyword i {
        vertical-align: middle;
        font-size: 0.8em;
        margin-left: 5px;
        color: rgba(29, 30, 122, 0.24);
    }

    div.input-theme:focus {
        border: 2px solid #3E3FA0;
    }

    input {
        outline: none;
        border: none;
        width: 100%;
    }

    input::placeholder {
        color: transparent !important;
    }

    /*input:not(:placeholder-shown) {*/
        /*padding: 1.25rem 1.5rem 0.25rem;*/
    /*}*/

    label {
        position: absolute;
        top: 0;
        left: 0;
        margin: 0;
        padding: 0.75rem 1.5rem;
        color: #aaa;
        border: 3px solid transparent;
        pointer-events: none;
        transition: 0.2s ease all;
        -moz-transition: 0.2s ease all;
        -webkit-transition: 0.2s ease all;

        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
        width: 100%;
    }

    input:not(:placeholder-shown) ~ label, div.has-tags ~ label {
        font-size: 0.75rem;
        padding-top: 0.25rem
    }

    .invalid-feedback {
        display: block;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }

    /* Fallback for Edge */
    @supports (-ms-ime-align: auto) {
        label {
            display: none;
        }
        input::-ms-input-placeholder {
            color: #777;
        }
    }

    /* Fallback for IE */
    @media all and (-ms-high-contrast: none), (-ms-high-contrast: active) {
        label {
            display: none;
        }
        input:-ms-input-placeholder {
            color: #777;
        }
    }
</style>