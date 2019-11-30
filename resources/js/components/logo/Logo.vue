<template>
    <svg xmlns="http://www.w3.org/2000/svg"
         xmlns:xlink="http://www.w3.org/1999/xlink"
         :width="width"
         :height="height"
         :viewBox="'0 0 ' + width + ' ' + height"
         fill="none"
    >
        <rect v-if="backgroundColor" id="background" :width="width" :height="height" :fill="backgroundColor"></rect>
        <g class="scaler" :transform="transform">
            <container
                    :transform="containerTransform"
            ></container>
            <logo-symbol
                    :class="draggable ? 'draggable' : ''"
                    :transform="symbolTransform"
            ></logo-symbol>
            <company-name
                    :transform="companyNameTransform"
            ></company-name>
            <slogan
                    :transform="sloganTransform"
            ></slogan>
            <g v-for="(placeholder, idx) in placeholders" :key="idx"
               :transform="placeholder.transform">
                <rect :width="symbolWidth" :height="symbolHeight" stroke="red"></rect>
            </g>
        </g>
        <template v-if="showWaterMark">
            <pattern id="watermark-pattern" viewBox="0 0 256 256" height="256" width="256" patternUnits="userSpaceOnUse">
                <g xmlns="http://www.w3.org/2000/svg" transform="translate(32, 32) scale(2, 2)" opacity="0.5">
                    <path d="M1.00049 77.7821L3.27635 75.5062L13.4636 85.6935L19.8715 79.2856L21.7714 81.1854L13.0876 89.8692L1.00049 77.7821Z" fill="black" fill-opacity="0.1" stroke="black" stroke-opacity="0.07"/>
                    <path d="M18.3338 75.4013C15.5708 72.6383 15.7212 68.5865 18.5915 65.7163C21.4975 62.8102 25.5322 62.677 28.2951 65.4399C31.058 68.2028 30.9418 72.2544 28.0357 75.1605C25.1655 78.0307 21.0953 78.1628 18.3338 75.4013ZM26.0894 67.6456C24.328 65.8842 22.0162 65.9528 20.4236 67.5455C18.8481 69.121 18.7794 71.4327 20.5409 73.1942C22.3023 74.9556 24.6141 74.8869 26.1896 73.3115C27.7822 71.7188 27.8495 69.4056 26.0894 67.6456Z" fill="black" fill-opacity="0.1" stroke="black" stroke-opacity="0.07"/>
                    <path d="M35.502 49.0119L43.3232 56.8331C46.6723 60.1822 46.4234 63.471 43.1507 66.7437C41.4005 68.4939 39.2182 69.7777 37.2867 69.9831L36.6448 67.379C38.1421 67.2293 39.9021 66.331 41.1983 65.0348C43.2636 62.9694 43.2422 61.1263 41.3777 59.2617L40.8946 58.7786C40.9532 60.3783 40.2473 61.8781 38.9869 63.1385C36.3086 65.8168 32.4651 66.0696 29.7883 63.3928C27.1116 60.7161 27.3997 56.9079 30.078 54.2296C31.3914 52.9162 32.9597 52.1757 34.6456 52.3205L33.4195 51.0944L35.502 49.0119V49.0119ZM37.6815 55.4997C36.1277 53.9459 33.8838 54.0823 32.2381 55.728C30.5753 57.3908 30.4388 59.6348 31.9926 61.1886C33.5633 62.7593 35.8243 62.6398 37.4871 60.977C39.1328 59.3313 39.2523 57.0704 37.6815 55.4997Z" fill="black" fill-opacity="0.1" stroke="black" stroke-opacity="0.07"/>
                    <path d="M42.6507 51.0845C39.8877 48.3216 40.0381 44.2697 42.9084 41.3995C45.8144 38.4934 49.8491 38.3602 52.612 41.1231C55.3749 43.8861 55.2587 47.9377 52.3526 50.8437C49.4824 53.714 45.4122 53.846 42.6507 51.0845ZM50.4063 43.3288C48.6449 41.5674 46.3331 41.636 44.7405 43.2287C43.165 44.8042 43.0963 47.1159 44.8578 48.8774C46.6192 50.6388 48.931 50.5702 50.5064 48.9947C52.0977 47.4034 52.1664 45.0888 50.4063 43.3288Z" fill="black" fill-opacity="0.1" stroke="black" stroke-opacity="0.07"/>
                    <path d="M68.1389 25.596C65.376 22.833 65.5264 18.7812 68.3967 15.911C71.3027 13.0049 75.3374 12.8717 78.1003 15.6346C80.8632 18.3975 80.747 22.4491 77.8409 25.3552C74.9707 28.2254 70.9004 28.3575 68.1389 25.596ZM75.8946 17.8403C74.1332 16.0788 71.8214 16.1475 70.2273 17.7416C68.6518 19.3171 68.5832 21.6288 70.3446 23.3903C72.1061 25.1517 74.4178 25.0831 75.9933 23.5076C77.5874 21.9135 77.6546 19.6003 75.8946 17.8403Z" fill="black" fill-opacity="0.1" stroke="black" stroke-opacity="0.07"/>
                    <path d="M90.3674 11.5856C90.2557 12.5251 89.6756 13.5205 88.8878 14.3082C86.8397 16.3564 84.596 16.4587 82.5591 14.4218L78.1209 9.98361L76.5798 11.5247L74.8537 9.7986L76.3948 8.25749L74.2887 6.15139L76.4772 3.9629L78.5833 6.069L81.0868 3.56541L82.813 5.29153L80.3094 7.79512L84.6953 12.1811C85.5937 13.0794 86.5322 13.1071 87.373 12.2663C87.8284 11.8109 88.1438 11.2525 88.219 10.6603L90.3674 11.5856Z" fill="black" fill-opacity="0.1" stroke="black" stroke-opacity="0.07"/>
                    <path d="M53.2673 29.0372L55.1421 27.1624C56.7176 25.5869 58.1622 25.2469 59.2852 26.3699C60.3898 27.4745 60.0498 28.9191 58.4743 30.4946L56.8372 32.1316L58.5803 33.8747L60.6728 31.7822C62.3887 30.0663 63.8521 29.6736 65.0612 30.8827C65.6178 31.4393 65.8298 32.0494 65.737 32.7128L68.7991 32.3232C68.9974 31.0062 68.5832 29.8186 67.5789 28.8143C66.0081 27.2435 64.0974 27.1174 62.3687 28.0155C62.814 26.5701 62.5289 25.0246 61.2858 23.7816C59.369 21.8648 56.5674 22.2142 53.6256 25.156L49.23 29.5516L53.2673 29.0372Z" fill="black" fill-opacity="0.1" stroke="black" stroke-opacity="0.07"/>
                    <path d="M64.1658 35.264C64.1629 35.2669 64.1615 35.2683 64.1586 35.2712L60.482 38.9478L57.6343 36.1001L56.9944 35.4602L55.2514 33.7172L54.353 32.8188L52.9602 31.426L48.9258 31.9404L59.969 42.9837L66.0618 36.8908C66.7751 36.1776 67.3489 35.4795 67.786 34.8023L64.1658 35.264Z" fill="black" fill-opacity="0.1" stroke="black" stroke-opacity="0.07"/>
                </g>
            </pattern>
            <rect id="watermark" fill="url(#watermark-pattern)" x="0" y="0" :width="width" :height="height"></rect>
        </template>
    </svg>
</template>

<script>
  import Container from './components/Container.vue';
  import CompanyName from './components/CompanyName.vue';
  import Slogan from './components/Slogan.vue';
  import LogoSymbol from './components/Symbol.vue';
  import LogoPlacementMixin from '../../mixins/LogoPlacement.js';
  import LogoAdjustScaleMixin from '../../mixins/LogoAdjustScale.js';
  import LogoDraggableMixin from '../../mixins/LogoDraggable.js';
  import colorInvertingHelper from '../../helpers/colorInvertingHelper.js';

  export default {
    name: "Logo",
    props: {
      showWaterMark: {
        type: Boolean,
        default: function() {
          return false;
        }
      }
    },
    mixins: [
      LogoPlacementMixin,
      LogoAdjustScaleMixin,
      LogoDraggableMixin,
    ],
    components: {
      Container,
      CompanyName,
      Slogan,
      LogoSymbol,
    },
    computed: {
      layout: {
        get() {
          return this.$store.state.layout;
        },
        set(layout) {
          this.$store.dispatch('updateLayout', layout);
        },
      },
      backgroundColor() {
        return this.$store.getters.backgroundColor;
      },
      width() {
        return this.$store.state.width;
      },
      height() {
        return this.$store.state.height;
      },
      scale: {
        get() {
          return this.$store.state.scale;
        },
        set(scale) {
          this.$store.dispatch('updateScale', scale);
        }
      },
      containerWidth() {
        return this.$store.getters['container/width'];
      },
      containerHeight() {
        return this.$store.getters['container/height'];
      },
      containerScale() {
        return this.$store.getters['container/scale'];
      },
      companyNameWidth() {
        return this.$store.getters['companyName/width'];
      },
      companyNameHeight() {
        return this.$store.getters['companyName/height'];
      },
      companyNameScale() {
        return this.$store.state.companyName.scale;
      },
      companyNameIsPlaced() {
        return !!this.$store.state.companyName.text;
      },
      companyNameLineSpaceRate() {
        return this.$store.getters['companyName/lineSpaceRate'];
      },
      sloganWidth() {
        return this.$store.getters['slogan/width'];
      },
      sloganHeight() {
        return this.$store.getters['slogan/height'];
      },
      sloganScale() {
        return this.$store.state.slogan.scale;
      },
      sloganIsPlaced() {
        return this.$store.state.slogan.text;
      },
      sloganLineSpaceRate() {
        return this.$store.getters['slogan/lineSpaceRate'];
      },
      symbolType() {
        return this.$store.getters['symbol/type'];
      },
      symbolWidth() {
        return this.$store.getters['symbol/width'];
      },
      symbolHeight() {
        return this.$store.getters['symbol/height'];
      },
      symbolScale() {
        return this.$store.getters['symbol/scale'];
      },
      symbolIsPlaced() {
        return !!this.$store.getters['symbol/isPlaced'];
      },
      symbolLineSpaceRate() {
        return this.$store.getters['symbol/lineSpaceRate'];
      },
      waterMarkColor() {
        return colorInvertingHelper.invert(this.backgroundColor);
      },
    },
  }
</script>

<style scoped>
    .draggable {
        cursor: move;
    }
    #watermark {
        pointer-events: none;
    }
</style>