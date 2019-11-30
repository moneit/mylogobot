<template>
    <div>
        <div class="card-carousel-wrapper">
            <div class="card-carousel--nav__left"
                 @click="moveCarousel(-1)"
                 :disabled="atHeadOfList"
            ></div>
            <div class="card-carousel">
                <div class="card-carousel--overflow-container">
                    <div class="card-carousel-cards"
                         :style="{ transform: 'translateX' + '(' + currentOffset + 'px' + ')'}"
                    >
                        <div class="card-carousel--card"
                             :style="cardInlineStyle"
                             v-for="item in items"
                        >
                            <div class="card-carousel--card--body">
                                <img src="/img/landing/quote.png" />
                                <p>
                                    {{ item.description }}
                                </p>
                            </div>
                            <div class="card-carousel--card--footer">
                                <p class="color-secondary">
                                    {{ item.author }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-carousel--nav__right"
                 @click="moveCarousel(1)"
                 :disabled="atEndOfList"
            ></div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Carousel",
        props: {
            items: {
                type: Array,
                default: function() {
                    return [];
                }
            }
        },
        data() {
            return {
                currentOffset: 0,
                windowSize: 3,
                elementWidth: 0,
            }
        },
        mounted() {
            this.elementWidth = this.$el.offsetWidth;
        },
        computed: {
            cardWidth() {
                if (this.elementWidth < 640) {
                    return this.elementWidth;
                } else {
                    return (this.elementWidth - 20) / 2;
                }
            },
            cardInlineStyle() {
                return {
                    'min-width':  this.cardWidth + 'px',
                }
            },
            paginationFactor() {
                return this.cardWidth + 20;
            },
            atEndOfList() {
                return this.currentOffset <= (this.paginationFactor * -1) * (this.items.length - this.windowSize);
            },
            atHeadOfList() {
                return this.currentOffset === 0;
            },
        },
        methods: {
            moveCarousel(direction) {
                // Find a more elegant way to express the :style. consider using props to make it truly generic
                if (direction === 1 && !this.atEndOfList) {
                    this.currentOffset -= this.paginationFactor;
                } else if (direction === -1 && !this.atHeadOfList) {
                    this.currentOffset += this.paginationFactor;
                }
            },
        }
    }
</script>

<style lang="scss" scoped>
    .card-carousel-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #374047;
    }

    .card-carousel {
        width: 100%;

        &--overflow-container {
            overflow: hidden;
        }

        &--nav__left,
        &--nav__right {
            display: inline-block;
            width: 15px;
            height: 15px;
            padding: 10px;
            box-sizing: border-box;
            border-top: 5px solid white;
            border-right: 5px solid white;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
            /*transition: transform 300ms;*/

            &[disabled] {
                visibility: hidden;
            }
        }

        &--nav__left {
            transform: rotate(-135deg);

            &:active {
                transform: rotate(-135deg) scale(0.9);
            }
        }

        &--nav__right {
            transform: rotate(45deg);

            &:active {
                transform: rotate(45deg) scale(0.9);
            }
        }
    }

    .card-carousel-cards {
        display: flex;
        align-items: flex-start;
        transition: transform 300ms ease-out;
        transform: translatex(0px);

        .card-carousel--card {
            margin: 0 10px 2px;
            padding: 2rem;
            cursor: pointer;
            box-shadow: 0 4px 15px 0 rgba(40,44,53,.06), 0 2px 2px 0 rgba(40,44,53,.08);
            background-color: #fff;
            border-radius: 4px;
            z-index: 3;

            &:first-child {
                margin-left: 0;
            }

            &:last-child {
                 margin-right: 0;
            }

            &--body {
                padding-bottom: 1rem;
                border-bottom: 1px solid #DEE1E3;

                img {
                    margin-bottom: 1.25rem;
                }
            }

            &--footer {
                border-top: 0;
                padding-top: 1rem;

                p {
                    padding: 3px 0;
                    margin: 0;
                    margin-bottom: 2px;
                    font-size: 19px;
                    font-weight: 500;
                    user-select: none;
                }
            }
        }
    }
</style>