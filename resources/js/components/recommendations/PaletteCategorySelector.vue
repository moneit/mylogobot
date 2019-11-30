<template>
    <div class="row ml-0 mr-0">
        <div class="col-3 p-3" v-for="(palette, category) in paletteCategories" :key="category">
            <input type="checkbox" :id="category" name="palette" @change="toggleTickedPalette(palette)">
            <label :for="category" class="w-100 pointer">
                <div class="square-box-container">
                    <div class="square-box">
                        <div class="square-box-container">
                            <div class="square-box rounded-circle shadow" :style="{backgroundColor: palette.hex}"></div>
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>
</template>

<script>
  export default {
    name: "PaletteCategorySelector",
    created() {
      this.$store.dispatch('initPalette');
    },
    computed: {
      paletteCategories() {
        return this.$store.state.paletteCategories;
      },
    },
    methods: {
      toggleTickedPalette(palette) {
        this.$store.dispatch('updateTickedPalette', palette);
      }
    },
  }
</script>

<style lang="scss" scoped>
    input[type=checkbox] {
        display: none;
        background-color: #1E1C1A;
    }

    input:checked + label::after {
        content: "";
        position: absolute;
        left: calc(50% - 5px);
        top: calc(50% - 5px);
        background: white;
        width: 3px;
        height: 3px;
        box-shadow: 2px 0 0 white, 4px 0 0 white, 4px -2px 0 white, 4px -4px 0 white, 4px -6px 0 white, 4px -8px 0 white;
        transform: rotate(45deg);
    }

    .col-3 {
        text-align: center;
        padding: 0.25rem !important;

        & > label, & > div {
            margin: auto;
            max-width: 35px;
            max-height: 35px;
        }
    }
</style>