<template>
    <div>
        <label :for="module + '-icon-selector-toggle'" class="btn btn-outline-dark w-100">Change Icon</label>
        <div>
            <input :id="module + '-icon-selector-toggle'" class="icon-selector-toggle" type="checkbox" v-model="open">
            <label :for="module + '-icon-selector-toggle'" class="overlay"></label>
            <div class="icon-selector p-3 overflow-auto">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="input-group">
                            <input class="form-control" v-model="keyword" placeholder="Search by keyword" @keyup.enter="getIcons()"/>
                            <div class="input-group-append pointer" @click="getIcons">
                                <span class="input-group-text logobot-icon icon-search"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-md-2 icon-card"
                         v-for="(preview_url, idx) in urls"
                         :key="idx"
                    >
                        <img class="rounded" :src="preview_url" @click="selectIcon(preview_url)"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LogoAdjustment from '../../mixins/LogoAdjustment.js';
    import iconApi from '../../services/api/icons';

    export default {
        name: "IconSelector",
        mixins: [LogoAdjustment],
        data() {
            return {
                open: false,
                urls: [],
                keyword: '',
            }
        },
        methods: {
            selectIcon(url) {
                this.updateValue(url);
                this.open = false;
            },
            getIcons() {
                this.$store.dispatch('symbol/updateLoading', true);

                iconApi.getIcons({
                    'search-input': this.keyword
                })
                    .then((res) => {
                        if (res.status === 'success') {
                            this.urls = res.payload.body;
                        } else {
                            console.log(res.payload.message);
                        }
                    })
                    .finally(() => {
                        this.$store.dispatch('symbol/updateLoading', false);
                    });
            },
        },
        watch: {
            open(value) {
                if (this.open) {
                    this.getIcons();
                }
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>