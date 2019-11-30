<template>
    <g class="logo-group" id="logo-slogan" :fill="color" :style="{opacity: opacity}" :width="width" :height="height" :scale="scale">
        <path v-for="(path, idx) in paths" :key="path.char + idx"
              :d="path.path"
              :transform="getPathTransform(idx)"
        ></path>
    </g>
</template>

<script>
  import fontApi from '../../../services/api/fonts.js';

  export default {
    name: "Slogan",
    props: {
      previewMode: {
        type: Boolean,
        default: function() {
          return false;
        }
      },
      previewSettings: {
        type: Object,
        default: function() {
          return {}
        },
      },
      previewFail: {
        type: Boolean,
        default: function() {
          return false;
        }
      },
    },
    data() {
      return {
        module: 'slogan',
      }
    },
    mounted() {
      if (this.previewMode) {
        if (this.previewSettings.font.id) {
          Promise.all([
            this.getPreviewPaths(),
            this.getPreviewFontBounds(),
            this.getPreviewFontAdvX(),
          ]).finally(() => {
            this.$emit('api-completed');
          });
        } else {
          this.$emit('api-completed');
          console.log('The preview font is not provided to get slogan preview data.');
        }
      }
    },
    computed: {
      fontSize() {
        if (this.previewMode) {
          return this.previewSettings.fontSize;
        }
        return this.$store.state[this.module].fontSize;
      },
      lineSpace() {
        if (this.previewMode) {
          return this.previewSettings.lineSpace;
        }
        return this.$store.state[this.module].lineSpace;
      },
      letterSpace() {
        if (this.previewMode) {
          return this.previewSettings.letterSpace;
        }
        return this.$store.state[this.module].letterSpace;
      },
      color() {
        if (this.previewMode) {
          return this.previewSettings.color.hex;
        }
        return this.$store.state[this.module].color.hex;
      },
      opacity() {
        if (this.previewMode) {
          return this.previewSettings.color.a;
        }
        return this.$store.state[this.module].color.a;
      },
      paths() {
        if (this.previewMode) {
          return this.previewSettings.paths;
        }
        return this.$store.state[this.module].paths;
      },
      fontAdvX() {
        if (this.previewMode) {
          return this.previewSettings.fontAdvX;
        }
        return this.$store.state[this.module].fontAdvX;
      },
      fontBounds() {
        if (this.previewMode) {
          return this.previewSettings.fontBounds;
        }
        return this.$store.state[this.module].fontBounds;
      },
      viewY() {
        if (!isNaN(this.fontBounds['maxY']) && !isNaN(this.fontBounds['minY'])) {
          return this.fontBounds['maxY'] - this.fontBounds['minY'];
        }
        return 0;
      },
      scale() {
        if (this.viewY === 0) {
          return 1;
        } else {
          return 768 / this.viewY * this.fontSize / 100;
        }
      },
      width() {
        return this.paths.reduce((width, path, idx) => {
          width += path['horiz-adv-x'];
          if (idx > 0) {
            width += this.fontAdvX * this.letterSpace / 100;
          }
          return width;
        }, 0);
      },
      height() {
        return this.fontBounds['maxY'] - this.fontBounds['minY'];
      },
    },
    methods: {
      getPathTransform(idx) {
        let offsetX = this.getPathOffsetX(idx);
        let offsetY = this.getPathOffsetY(idx);

        return 'scale(1, -1) translate(' + offsetX + ' ' + offsetY + ')';
      },
      getPathOffsetX(idx) {
        let offsetX = 0;
        for(let i = 0; i < idx; i++) {
          offsetX += this.paths[i]['horiz-adv-x'];
          offsetX += this.fontAdvX * this.letterSpace / 100;
        }

        return offsetX;
      },
      getPathOffsetY() {
        return isNaN(this.fontBounds['maxY']) ? 0 : -this.fontBounds['maxY'];
      },
      // preview mode
      getPreviewPaths() {
        if (this.previewSettings.text) { // reduce unnecessary api call
          return fontApi.getPaths({
            string: this.previewSettings.text,
            capitalization: this.previewSettings.capitalization,
            fontId: this.previewSettings.font.id,
          }, (data) => {
            if (data.status === 'success') {
              this.previewSettings.paths = data.payload.paths;
              this.updatePreviewSettingsProp();
            }
          }, (error) => {
            this.$emit('update:previewFail', true);
          });
        }
      },

      getPreviewFontBounds () {
        return fontApi.getBounds({
          fontId: this.previewSettings.font.id,
        }, (data) => {
          if (data.status === 'success') {
            this.previewSettings.fontBounds = data.payload.bounds;
            this.updatePreviewSettingsProp();
          }
        }, (error) => {
          this.$emit('update:previewFail', true);
        });
      },

      getPreviewFontAdvX () {
        return fontApi.getHorizAdvX({
          fontId: this.previewSettings.font.id,
        }, (data) => {
          if (data.status === 'success') {
            this.previewSettings.fontAdvX = data.payload.globalAdvX;
            this.updatePreviewSettingsProp();
          }
        }, (error) => {
          this.$emit('update:previewFail', true);
        });
      },

      updatePreviewSettingsProp () {
        this.$emit('update:previewSettings', Object.assign({}, this.previewSettings));
      },
    },
    watch: {
      width(value) {
        if (this.previewMode) {
          this.previewSettings.width = value;
          this.updatePreviewSettingsProp();
        } else {
          this.$store.dispatch('slogan/updateWidth', value);
        }
      },

      height(value) {
        if (this.previewMode) {
          this.previewSettings.height = value;
          this.updatePreviewSettingsProp();
        } else {
          this.$store.dispatch('slogan/updateHeight', value);
        }
      },

      scale(value) {
        if (this.previewMode) {
          this.previewSettings.scale = value;
          this.updatePreviewSettingsProp();
        } else {
          this.$store.dispatch('slogan/updateScale', value);
        }
      },
    }
  }
</script>

<style scoped>

</style>