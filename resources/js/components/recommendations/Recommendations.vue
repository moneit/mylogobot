<template>
    <div class="row" style="margin: 0;">
        <div class="col-md-2 bg-white order-md-last" style="padding: 0 32px;" ref="rail">
            <div class="row pt-3 pb-0 rounded">
                <div class="col-12 color-primary d-flex mb-30">
                    <i class="logobot-icon icon-fa-sliders-h mr-1" style="line-height: 1.6;"></i>Change logo settings
                </div>
                <options-panel></options-panel>
            </div>
        </div>

        <div class="col-md-10" style="padding: 11px;">
            <logo-recommendations
                    @set-preview-settings="setPreviewSettings"
                    @store-history-data="storeHistoryData"
                    @rendering-completed="renderingCompleted"
            ></logo-recommendations>
        </div>
    </div>
</template>

<script>
  import OptionsPanel from './OptionsPanel.vue';
  import LogoRecommendations from './LogoRecommendations.vue';

  export default {
    name: "Recommendations",
    components: {
      OptionsPanel,
      LogoRecommendations,
    },
    data() {
      return {
        railOffsetTop: 0,
        railOffsetLeft: 0
      }
    },
    mounted() {
      if (this.$refs.rail) { // if desktop
        this.railOffsetTop = this.$refs.rail.offsetTop;
        this.railOffsetLeft = this.$refs.rail.offsetLeft - 15; // 15 is complementary for padding
        document.addEventListener('scroll', this.scrollListener.bind(this));
      }
    },
    beforeDestroy() {
      if (this.$refs.rail) { // if desktop
        document.removeEventListener('scroll', this.scrollListener);
      }
    },
    methods: {
      scrollListener() { // right fixed bar rail
        if (window.scrollY > this.railOffsetTop) {
          this.$refs.rail.style.position = "fixed";
          this.$refs.rail.style.right = 0;
          this.$refs.rail.style.top = 0;
          this.$refs.rail.style.bottom = 0;
        } else {
          this.$refs.rail.style.position = "static";
          this.$refs.rail.style.left = "";
          this.$refs.rail.style.right = "";
          this.$refs.rail.style.top = "";
          this.$refs.rail.style.bottom = "";
        }
      },
      setPreviewSettings(settings) {
        this.$emit('set-preview-settings', settings);
      },
      storeHistoryData(data) {
        this.$emit('store-history-data', data);
      },
      renderingCompleted() {
        this.$emit('rendering-completed');
      },
    }
  }
</script>

<style scoped>

</style>