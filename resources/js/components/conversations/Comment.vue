<template>
    <div class="comment-wrapper" :class="owner">
        <div class="comment" :class="owner" v-html="html">
        </div>
    </div>
</template>

<script>
    export default {
        props: ['owner', 'html'],
        mounted() {
        }
    }
</script>
