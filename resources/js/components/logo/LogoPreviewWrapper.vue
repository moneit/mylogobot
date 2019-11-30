<template>
    <logo-preview
            :preview-settings-prop="previewSettings.settings"
            :container-preview-settings-prop="previewSettings.containerSettings"
            :company-name-preview-settings-prop="previewSettings.companyNameSettings"
            :slogan-preview-settings-prop="previewSettings.sloganSettings"
            :symbol-preview-settings-prop="previewSettings.symbolSettings"
            v-on:update:preview-settings-prop="updateSettings"
            v-on:update:container-preview-settings-prop="updateContainerSettings"
            v-on:update:company-name-preview-settings-prop="updateCompanyNameSettings"
            v-on:update:slogan-preview-settings-prop="updateSloganSettings"
            v-on:update:symbol-preview-settings-prop="updateSymbolSettings"
            v-on:preview-fail="onPreviewFail"
            v-on:rendering-completed="onRenderingCompleted"
            :refresh="refreshPreview"
            :compact="compact"
            :show-background="showBackground"
            :show-water-mark="showWaterMark"
    ></logo-preview>
</template>

<script>
  import LogoPreview from './LogoPreview';

  export default {
    name: "LogoPreviewWrapper",
    components: { LogoPreview },
    props: {
      previewSettings: {
        type: Object,
        default: function() {
          return {}
        }
      },
      showBackground: {
        type: Boolean,
        default: function() {
          return true;
        }
      },
      compact: {
        type: Boolean,
        default: function () {
          return false;
        }
      },
      showWaterMark: {
        type: Boolean,
        default: function() {
          return false;
        }
      },
    },
    data() {
      return  {
        refreshPreview: false,
      }
    },
    methods: {
      updateSettings(payload) {
        this.previewSettings.settings = payload;
      },
      updateContainerSettings(payload) {
        this.previewSettings.containerSettings = payload;
      },
      updateCompanyNameSettings(payload) {
        this.previewSettings.companyNameSettings = payload;
      },
      updateSloganSettings(payload) {
        this.previewSettings.sloganSettings = payload;
      },
      updateSymbolSettings(payload) {
        this.previewSettings.symbolSettings = payload;
      },
      onPreviewFail() {
        this.$emit('preview-fail');
      },
      onRenderingCompleted() {
        this.$emit('rendering-completed');
      },
    },
    watch: {
      previewSettings() {
        this.refreshPreview = true;
        this.$nextTick(() => {
          this.refreshPreview = false;
        });
      }
    }
  }
</script>

<style scoped>

</style>