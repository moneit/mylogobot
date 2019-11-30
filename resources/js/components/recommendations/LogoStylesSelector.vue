<template>
    <div class="row logo-samples-container">
        <div class="col-12 mb-3" v-for="kind in kinds" :key="kind.id">
            <div class="d-flex flex-column justify-content-center">
                <input type="checkbox" :id="kind.name" :checked="kind.selected" @change="updateSelection">
                <label :for="kind.name" class="d-flex flex-column pointer">
                    <span>
                        {{ kind.name }}<div class="q-mark">?</div>
                        <div>
                            <component :is="kind.component"></component>
                        </div>
                    </span>
                </label>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "LogoStylesSelector",
        computed: {
            kinds() {
                return this.$store.state.kinds;
            },
        },
        methods: {
            updateSelection($event) {
                this.$store.dispatch('updateSelectedKind', {
                    name: $event.target.id,
                    selected: $event.target.checked,
                });
            },
        }
    }
</script>

<style scoped lang="scss">
    input[type=checkbox] {
        position: absolute;
        opacity: 0;

        & + label {
            &::before {
                position: absolute;
                left: 1rem;
                content: '';
                display: inline-block;
                vertical-align: text-top;
                width: 1.25rem;
                height: 1.25rem;
                background: white;
                -webkit-border-radius: 1px;
                -moz-border-radius: 1px;
                border-radius: 1px;
                border: 1px solid #DEE1E3;
            }
            margin-left: 30px;
            span {
                display: inline-block;
            }
            .q-mark {
                display: inline-block;
                position: relative;
                width: 20px;
                height: 20px;
                margin-left: 5px;
                border-radius: 50%;
                text-align: center;
                color: rgba(29, 30, 122, 0.8);
                background-color: rgba(29, 30, 122, 0.1);
                cursor: pointer;
                
                & + div {
                    display: none;
                    position: absolute;
                    left: 50px;
                    top: -100px;
                    padding: 25px;
                    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
                    z-index: 1;
                    background-color: white;
                    border-radius: 5px;
                }
                
                &:hover + div {
                    display: block;
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
                left: 1.25rem;
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