<template>
    <div class="container">
        <quick-edit></quick-edit>

        <logo-recommendations
                @set-preview-settings="setPreviewSettings"
                @store-history-data="storeHistoryData"
                @rendering-completed="renderingCompleted"
        ></logo-recommendations>
    </div>
</template>

<script>
    const Recommendations = Vue.component('recommendations', require('./Recommendations.vue').default);
    const QuickEdit = Vue.component('quick-edit', require('./QuickEdit.vue').default);

    const RecommendationsMobile = Recommendations.extend({
        name: "RecommendationsMobile",
        components: {
            QuickEdit
        }
    });

    export default RecommendationsMobile;
</script>

<style scoped>

</style>