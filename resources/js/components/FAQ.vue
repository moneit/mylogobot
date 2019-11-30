<template>
    <div class="faq">
        <div class='btn quiz border-radius shadow w-100 pointer text-left p-3' :class='close ? "color-primary background-white" : "color-white background-primary"' @click='toggle'>
            <span>
                <i class='logobot-icon' :class='close ? "icon-plus" : "icon-minus"'></i>
            </span>
            <span class='px-3'>
                <slot name='quiz'></slot>
            </span>
        </div>
        <p class='answer rounded' v-show='!close'>
            <slot name='answer'></slot>
        </p>
    </div>
</template>

<script>
    export default {
        name: 'FAQ',
        data() {
            return {
                close: true,
            }
        },
        methods: {
            toggle() {
                this.close = !this.close;
            }
        }
    }
</script>

<style scoped lang='scss'>
    .faq {
        margin-bottom: 1rem;

        .answer {
            background-color: #EBEBF3;
            padding: 1rem 2rem;
        }
    }
</style>