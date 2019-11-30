<template>
    <g class="logo-group" id="logo-symbol" :style="{opacity: opacity}">
        <template v-if="type.label === 'Icon'">
            <clipPath :id="'icon-mask-' + id" v-if="notIncludeSwitch">
                <rect :x="iconOffsetX" :y="iconOffsetY" :width="iconWidth" :height="iconHeight"></rect>
            </clipPath>
            <g v-if="!iconHidden"
               :fill-rule="iconClipRule"
               :clip-rule="iconFillRule"
               :clip-path="'url(#icon-mask-' + id + ')'"
               v-html="html"
               :fill="colorByHex"
               :transform="iconTransform"
            ></g>
        </template>
        <template v-else>
            <path v-for="(path, idx) in paths" :key="path.char + idx"
                  :d="path.path"
                  :fill="colorByHex"
                  :transform="getPathTransform(idx)"
            ></path>
        </template>
    </g>
</template>

<script>
  import fontApi from '../../../services/api/fonts.js';
  import uid from '../../../helpers/uniqueIdHelper.js';

  export default {
    name: "LogoSymbol",
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
          return {};
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
        module: "symbol",
        id: uid.generate(),
      }
    },
    mounted() {
      if (this.previewMode) {
        if (this.type.label === 'Initials') {
          if (this.previewSettings.font.id) {
            Promise.all([
              this.getPreviewPaths(),
              this.getPreviewFontBounds(),
              this.getPreviewFontAdvX(),
            ]).finally((res) => {
              this.$emit('api-completed');
            });
          } else {
            this.$emit('api-completed');
            console.log('The preview font is not provided to get initials preview data.');
          }
        } else {
          this.previewSettings.iconWidth = this.iconWidth;
          this.previewSettings.iconHeight = this.iconHeight;
          this.previewSettings.iconScale = this.iconScale;
          this.previewSettings.initialsWidth = this.initialsWidth;
          this.previewSettings.initialsHeight = this.initialsHeight;
          this.previewSettings.initialsScale = this.initialsScale;
          this.updatePreviewSettingsProp();
          this.$emit('api-completed');
        }
      }
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
        return fontApi.getPaths({
          string: this.previewSettings.text,
          capitalization: '',
          fontId: this.previewSettings.font.id,
        }, (data) => {
          if (data.status === 'success') {
            this.previewSettings.paths = data.payload.paths;
            this.updatePreviewSettingsProp();
          }
        }, (error) => {
          this.$emit('update:previewFail', true);
        });
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
    computed: {
      type() {
        if (this.previewMode) {
          return this.previewSettings.types.find(type => type.selected);
        }
        return this.$store.getters['symbol/type'];
      },
      color() {
        if (this.previewMode) {
          return this.previewSettings.color.rgba;
        }
        return this.$store.state[this.module].color.rgba;
      },
      colorByHex() {
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
      url() {
        if (this.previewMode) {
          return this.previewSettings.url;
        }
        return this.$store.state[this.module].url;
      },
      tags() {
        if (this.previewMode) {
          return this.previewSettings.tags;
        }
        return this.$store.state[this.module].tags;
      },
      iconBounds() {
        if (this.previewMode) {
          return this.previewSettings.iconBounds;
        }
        return this.$store.state[this.module].iconBounds;
      },
      iconClipRule() {
        if (this.previewMode) {
          return this.previewSettings.iconClipRule;
        }
        return this.$store.state[this.module].iconClipRule;
      },
      iconFillRule() {
        if (this.previewMode) {
          return this.previewSettings.iconFillRule;
        }
        return this.$store.state[this.module].iconFillRule;
      },
      iconSize() {
        if (this.previewMode) {
          return this.previewSettings.iconSize;
        }
        return this.$store.state[this.module].iconSize;
      },
      iconWidth() {
        return Math.abs(this.iconBounds['maxX'] - this.iconBounds['minX']);
      },
      iconHeight() {
        return Math.abs(this.iconBounds['maxY'] - this.iconBounds['minY']);
      },
      iconScale() {
        if (this.iconHeight === 0) {
          return 1;
        } else {
          return Math.min(1024 / this.iconWidth, 768 / this.iconHeight) * this.iconSize / 100;
        }
      },
      iconOffsetX() {
        return this.iconBounds['minX'];
      },
      iconOffsetY() {
        return this.iconBounds['minY'];
      },
      iconTransform() {
        return 'translate(' + -this.iconOffsetX + ' ' + -this.iconOffsetY + ')';
      },
      iconHidden() {
        if (this.previewMode) {
          return this.previewSettings.iconHidden;
        }
        return this.$store.state[this.module].iconHidden;
      },
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
      paths() {
        if (this.previewMode) {
          return this.previewSettings.paths;
        }
        // if (this.previewMode && this.previewSettings.font.id) {
        //     return this.previewPaths;
        // }
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
      initialsWidth() {
        return this.paths.reduce((width, path, idx) => {
          width += path['horiz-adv-x'];
          if (idx > 0) {
            width += this.fontAdvX * this.letterSpace / 100;
          }
          return width;
        }, 0);
      },
      initialsHeight() {
        return this.fontBounds['maxY'] - this.fontBounds['minY'];
      },
      viewY() {
        if (!isNaN(this.fontBounds['maxY']) && !isNaN(this.fontBounds['minY'])) {
          return this.fontBounds['maxY'] - this.fontBounds['minY'];
        }
        return 0;
      },
      initialsScale() {
        if (this.viewY === 0) {
          return 1;
        } else {
          return 768 / this.viewY * this.fontSize / 100;
        }
      },
      html() {
        return this.tags.reduce((html, tag) => {
          return html + tag;
        }, '');
      },
      notIncludeSwitch() {
        return this.tags.length > 0 && this.tags[0].indexOf('<switch>') === -1;
      },
    },
    watch: {
      iconWidth(value) {
        if (this.previewMode) {
          return this.previewSettings.iconWidth = value;
        } else {
          this.$store.dispatch('symbol/updateIconWidth', value);
        }
      },
      iconHeight(value) {
        if (this.previewMode) {
          return this.previewSettings.iconHeight = value;
        } else {
          this.$store.dispatch('symbol/updateIconHeight', value);
        }
      },
      iconScale(value) {
        if (this.previewMode) {
          this.previewSettings.iconScale = value;
          this.updatePreviewSettingsProp();
        } else {
          this.$store.dispatch('symbol/updateIconScale', value);
        }
      },
      initialsWidth(value) {
        if (this.previewMode) {
          this.previewSettings.initialsWidth = value;
          this.updatePreviewSettingsProp();
        } else {
          this.$store.dispatch('symbol/updateInitialsWidth', value);
        }
      },
      initialsHeight(value) {
        if (this.previewMode) {
          this.previewSettings.initialsHeight = value;
          this.updatePreviewSettingsProp();
        } else {
          this.$store.dispatch('symbol/updateInitialsHeight', value);
        }
      },
      initialsScale(value) {
        if (this.previewMode) {
          this.previewSettings.initialsScale = value;
          this.updatePreviewSettingsProp();
        } else {
          this.$store.dispatch('symbol/updateInitialsScale', value);
        }
      },
    }
  }
</script>

<style scoped>

</style>