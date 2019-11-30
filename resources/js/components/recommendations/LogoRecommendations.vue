<template>
    <div class="row logo-recommendations">
        <div v-for="(logoRecommendation, idx) in logoRecommendations" :key="logoRecommendation.ts" class="col-md-4">
            <div class="logo-preview-container">
                <div :id="'logo-symbol-preview-' + logoRecommendation.ts"
                     class="logo-preview shadow rounded"
                     :class="previewFailedIndexes.includes(logoRecommendation.ts) ? 'preview-fail' : ''"
                     style="visibility: hidden;"
                >
                    <logo-symbol-preview-wrapper
                            v-if="logoRecommendation.settings"
                            :preview-settings="logoRecommendation"
                            @preview-fail="previewFailedIndexes.push(logoRecommendation.ts)"
                    ></logo-symbol-preview-wrapper>
                </div>
                <div :id="'logo-preview-' + logoRecommendation.ts"
                     class="logo-preview shadow rounded"
                     :class="previewFailedIndexes.includes(logoRecommendation.ts) ? 'preview-fail' : ''"
                >
                    <a href="/editor" @click="storeIntoLocal(logoRecommendation)" @auxclick="storeIntoLocal(logoRecommendation)">
                        <logo-preview-wrapper
                                v-if="logoRecommendation.settings"
                                :preview-settings="logoRecommendation"
                                :show-water-mark="true"
                                @preview-fail="previewFailedIndexes.push(logoRecommendation.ts)"
                                @rendering-completed="pushRenderedLogoTs(logoRecommendation.ts)"
                        ></logo-preview-wrapper>
                    </a>
                </div>
                <!--<div class="logo-saved rounded" v-if="logoRecommendation.settings && logoRecommendation.settings.id">-->
                    <!--<div class="h-100 d-flex flex-column justify-content-center align-items-center">-->
                        <!--<div>-->
                            <!--<i class="logobot-icon icon-heart"></i>-->
                        <!--</div>-->
                        <!--<div>-->
                            <!--Logo saved to your gallery!-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="logo-icons rounded">-->
                    <!--<div class="h-100 d-flex flex-column justify-content-end align-items-center">-->
                        <!--<div class="w-100 p-3 buttons-wrapper d-flex justify-content-around align-items-center">-->
                            <!--<div class="w-50 text-left">-->
                                <!--<label class="btn btn-logo" @click="store(logoRecommendation)">-->
                                    <!--<i class="logobot-icon icon-heart"></i>-->
                                    <!--<span></span>-->
                                <!--</label>-->
                                <!--<a href="/editor" @click="storeIntoLocal(logoRecommendation)" @auxclick="storeIntoLocal(logoRecommendation)">-->
                                    <!--<label class="btn btn-logo">-->
                                        <!--<i class="logobot-icon icon-edit"></i>-->
                                        <!--<span></span>-->
                                    <!--</label>-->
                                <!--</a>-->
                                <!--<label for="preview-toggle" class="btn btn-logo" @click="setPreviewSettings(logoRecommendation)">-->
                                    <!--<i class="logobot-icon icon-eye"></i>-->
                                    <!--<span></span>-->
                                <!--</label>-->
                            <!--</div>-->
                            <!--<div class="w-50 text-center">-->
                                <!--<label class="btn btn-theme gradient-secondary-90 w-100" @click="download(logoRecommendation)">-->
                                    <!--<span>Download</span>-->
                                <!--</label>-->
                            <!--</div>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="logo-loader" v-if="!renderedPreviewIndexes.includes(logoRecommendation.ts)">
                    <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                        <div class="spinner-border text-light" role="status">
                            <span class="sr-only">Rendering...</span>
                        </div>
                        <div class="text-light mt-3">Rendering</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-md-block w-100 text-center mt-10">
            <button class="btn btn-theme gradient-secondary-90 px-5 py-2" @click="generateMoreLogos">Design 6 more logos</button>
        </div>
        <div class="col-12 d-md-none mb-3 text-center">
            <button id="btn-generate" class="background-primary color-white mt-5 px-5 py-2 rounded" @click="refreshLogos">
                <i class="logobot-icon icon-refresh mr-3"></i>Refresh logos
            </button>
        </div>
    </div>
</template>

<script>
  import LogoPreviewWrapper from '../logo/LogoPreviewWrapper.vue';
  import LogoSymbolPreviewWrapper from '../logo-symbol/LogoSymbolPreviewWrapper.vue';
  import lsHelper from '../../helpers/localStorageHelper.js';
  import logoApi from "../../services/api/logo";

  export default {
    name: "LogoRecommendations",
    components: {
      LogoPreviewWrapper,
      LogoSymbolPreviewWrapper,
    },
    data() {
      return {
        previewFailedIndexes: [],
        renderedPreviewIndexes: [],
      }
    },
    computed: {
      logoRecommendations() {
        return this.$store.getters['recommendation/logoRecommendations'];
      },
      logoRecommendationsCount() {
        return this.$store.getters['recommendation/count'];
      },
    },
    methods: {
      storeIntoLocal(logoRecommendation) {
        lsHelper.set('logoSettings', logoRecommendation);
      },
      setPreviewSettings(settings) {
        this.$emit('set-preview-settings', JSON.parse(JSON.stringify(settings)));
      },
      store(logoRecommendation) {
        return new Promise((resolve, reject) => {

          let symbolOnlySvg = document.getElementById('logo-symbol-preview-' + logoRecommendation.ts).innerHTML;
          symbolOnlySvg = symbolOnlySvg.split(' ').filter(function(snippet) {
            return !snippet.includes('data-v-');
          }).join(' ');

          let svg = document.getElementById('logo-preview-' + logoRecommendation.ts).innerHTML;
          svg = svg.split(' ').filter(function(snippet) {
            return !snippet.includes('data-v-');
          }).join(' ');

          let params = {
            symbol_only_svg: symbolOnlySvg,
            svg: svg,
            id: logoRecommendation.settings.id,
            bg_color: logoRecommendation.settings.backgroundColor.hex,
            layout: logoRecommendation.settings.layout,
            scale: logoRecommendation.settings.scale,
          };
          params.name = {
            id: logoRecommendation.companyNameSettings.id,
            font_id: logoRecommendation.companyNameSettings.font.id,
            text: logoRecommendation.companyNameSettings.text,
            font_size: logoRecommendation.companyNameSettings.fontSize,
            letter_space: logoRecommendation.companyNameSettings.letterSpace,
            line_space: logoRecommendation.companyNameSettings.lineSpace,
            color_hex: logoRecommendation.companyNameSettings.color.hex,
            color_opacity: logoRecommendation.companyNameSettings.color.rgba.a,
            capitalization: logoRecommendation.companyNameSettings.capitalization,
          };
          params.slogan = {
            id: logoRecommendation.sloganSettings.id,
            font_id: logoRecommendation.sloganSettings.font.id,
            text: logoRecommendation.sloganSettings.text,
            font_size: logoRecommendation.sloganSettings.fontSize,
            letter_space: logoRecommendation.sloganSettings.letterSpace,
            line_space: logoRecommendation.sloganSettings.lineSpace,
            color_hex: logoRecommendation.sloganSettings.color.hex,
            color_opacity: logoRecommendation.sloganSettings.color.rgba.a,
            capitalization: logoRecommendation.sloganSettings.capitalization,
          };
          params.icon = {
            id: logoRecommendation.symbolSettings.iconId,
            tags: logoRecommendation.symbolSettings.tags,
            bounds: logoRecommendation.symbolSettings.iconBounds,
            clip_rule: logoRecommendation.symbolSettings.iconClipRule,
            fill_rule: logoRecommendation.symbolSettings.iconFillRule,
            size: logoRecommendation.symbolSettings.iconSize,
            line_space: logoRecommendation.symbolSettings.lineSpace,
            color_hex: logoRecommendation.symbolSettings.color.hex,
            color_opacity: logoRecommendation.symbolSettings.color.rgba.a,
            hidden: logoRecommendation.symbolSettings.iconHidden,
          };
          params.initials = {
            id: logoRecommendation.symbolSettings.initialsId,
            font_id: logoRecommendation.symbolSettings.font.id,
            text: logoRecommendation.symbolSettings.text,
            font_size: logoRecommendation.symbolSettings.fontSize,
            letter_space: logoRecommendation.symbolSettings.letterSpace,
            line_space: logoRecommendation.symbolSettings.lineSpace,
            color_hex: logoRecommendation.symbolSettings.color.hex,
            color_opacity: logoRecommendation.symbolSettings.color.rgba.a,
          };
          params.container = {
            id: logoRecommendation.containerSettings.id,
            container_id: logoRecommendation.containerSettings.selected.id,
            size: logoRecommendation.containerSettings.size,
            color_hex: logoRecommendation.containerSettings.color.hex,
            color_opacity: logoRecommendation.containerSettings.color.rgba.a,
          };

          logoApi.save(params, (res) => {
            if (res.status === 'success') {
              let result = res.payload.result;

              if (result.id) logoRecommendation.settings.id = result.id;
              if (result.name_id) logoRecommendation.companyNameSettings.id = result.name_id;
              if (result.slogan_id) logoRecommendation.sloganSettings.id = result.slogan_id;
              if (result.icon_id) logoRecommendation.symbolSettings.iconId = result.icon_id;
              if (result.initials_id) logoRecommendation.symbolSettings.initialsId = result.initials_id;
              if (result.logo_container_id) logoRecommendation.containerSettings.id = result.logo_container_id;

              resolve(logoRecommendation);
            }
          }, (err) => {
            console.log('err', err);
            reject(err);
          });
        });
      },
      download(logoRecommendation) {
        this.storeGoPackagesPage(logoRecommendation)
      },
      storeGoPackagesPage(logoRecommendation) {
        this.store(logoRecommendation)
          .then((r) => {
            this.goToPackagesPage(r);
          });
      },
      goToPackagesPage(logoRecommendation) {
        lsHelper.set('downloadSettings', {
          'logoId': logoRecommendation.settings.id
        });
        window.location.href = window.location.origin + '/packages';
      },
      pushRenderedLogoTs(ts) {
        this.renderedPreviewIndexes.push(ts);
        if (this.renderedPreviewIndexes.length === this.logoRecommendationsCount) {
          this.$emit('rendering-completed');
        }
      },
      generateMoreLogos() {
        this.$store.dispatch('recommendation/generateLogos')
          .then(() => {
            this.$nextTick(() => {
              window.scrollTo(0, document.body.scrollHeight);
            });
          });
      },
      refreshLogos() {
        this.$store.dispatch('recommendation/refreshLogos');
      },
    },
    watch: {
      logoRecommendations(value) {
        this.$emit('store-history-data', JSON.parse(JSON.stringify(value)));
      },
    }
  }
</script>

<style scoped>
    .col-md-4 {
        padding: 5px;
    }
    .logo-recommendations {
        margin: 0;
    }
</style>