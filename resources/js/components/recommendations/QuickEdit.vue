<template>
    <div class="row">
        <div class="w-100">
            <div class="color-primary d-flex justify-content-center px-4 py-3" @click="toggleDropdown">
                <i class="logobot-icon icon-fa-sliders-h mr-1" style="line-height: 1.6;"></i>Change logo settings
            </div>
        </div>
        <div v-if="open">
            <options-panel></options-panel>
        </div>
    </div>
</template>

<script>
  import OptionsPanel from './OptionsPanel.vue';

  export default {
    name: "QuickEdit",
    components: {
      OptionsPanel,
    },
    data() {
      return {
        open: false,
      }
    },
    methods: {
      toggleDropdown() {
        this.open = !this.open;
      },
      updateCheck($event) {
        this.$store.dispatch('updateCheckedColorCategory', {
          name: $event.target.id,
          checked: $event.target.checked,
        });
      },
      generateMoreLogos() {
        this.$store.dispatch('recommendation/generateLogos')
      }
    },
    computed: {
      colorCategories() {
        return this.$store.state.colorCategories;
      }
    },
  }
</script>

<style scoped lang="scss">
    input[type=checkbox] {
        position: absolute;
        opacity: 0;

        & + label {
            &::before {
                content: '';
                display: inline-block;
                vertical-align: text-top;
                width: 20px;
                height: 20px;
                margin-right: 0.5rem;
                background: white;
                -webkit-border-radius: 1px;
                -moz-border-radius: 1px;
                border-radius: 1px;
                border: 1px solid #DEE1E3;
            }

            position: relative;
            display: flex;
            cursor: pointer;
            padding: 0;

            .category-preview {
                width: 24px;
                height: 24px;

                .category-preview-row {
                    height: 8px;
                    display: flex;

                    .category-preview-item {
                        height: 8px;
                        width: 33.33%;
                    }
                }
            }
        }

        &:not([disabled]):hover + label {
            &::before {
                border: 1px solid #02DE84;
            }
        }

        &:checked + label {
            &::before {
                background: #02DE84;
                border: 1px solid #02DE84;
            }

            &::after {
                content: '';
                position: absolute;
                left: 5px;
                top: 9px;
                background: white;
                width: 2px;
                height: 2px;
                box-shadow:
                        2px 0 0 white,
                        4px 0 0 white,
                        4px -2px 0 white,
                        4px -4px 0 white,
                        4px -6px 0 white,
                        4px -8px 0 white;
                transform: rotate(45deg);
            }
        }
    }
</style>