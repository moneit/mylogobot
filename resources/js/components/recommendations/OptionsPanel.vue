<template>
    <div class="w-100">
        <div class="col-12">
            <logo-input
                    label="Company Name"
                    field="company-name-text"
            ></logo-input>
        </div>
        <div class="col-12">
            <logo-input
                    label="Slogan"
                    field="slogan-text"
            ></logo-input>
        </div>
        <div class="col-12 mb-3">
            <logo-key-words-input
                    label="Keywords"
                    field="company-details"
                    class="keywords-input"
            ></logo-key-words-input>
        </div>
        <div class="col-12">
            <div class="mb-10">Color Tones</div>
            <palette-category-selector class="mb-15"></palette-category-selector>
        </div>
        <div class="col-12">
            <div class="mb-20">Logo Styles</div>
            <logo-styles-selector></logo-styles-selector>
        </div>
        <div class="col-12">
            <div class="mb-3 rounded color-white background-primary" @click="refreshLogos" id="btn-generate">
                <a class="btn w-100 pointer">
                    <i class="logobot-icon icon-refresh"></i>
                    Refresh logos
                </a>
            </div>
        </div>
    </div>
</template>

<script>
  import LogoInput from '../LogoInput.vue';
  import LogoKeyWordsInput from './LogoKeyWordsInput.vue';
  import PaletteCategorySelector from './PaletteCategorySelector.vue';
  import LogoStylesSelector from './LogoStylesSelector.vue';

  export default {
    name: "OptionsPanel",
    components: {
      LogoInput,
      LogoKeyWordsInput,
      PaletteCategorySelector,
      LogoStylesSelector,
    },
    methods: {
      refreshLogos() {
        this.$store.dispatch('recommendation/refreshLogos')
      },
    }
  }
</script>

<style scoped>
    .keywords-input {
        color: transparent;
    }
    .keywords-input >>> div > div:first-child {
        margin-top: calc(0.5rem + 5px);
    }
</style>