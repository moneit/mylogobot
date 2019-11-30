<template>
    <div class="loader-container" v-show="show">
        <div class="loader-overlay">
        </div>
        <div class="h-100 d-flex justify-content-center align-items-center">
            <div class="spinner-border text-light" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Loader",
        computed: {
            show() {
                return this.$store.getters.loading;
            }
        }
    }
</script>

<style scoped>
    .loader-container {
        position: fixed;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        z-index: 9999;
    }

    .loader-overlay {
        position: absolute;
        left: 0;
        top: 0;
        width: 100vw;
        height: 100vh;
        background-color: black;
        opacity: 0.25;
    }
</style>