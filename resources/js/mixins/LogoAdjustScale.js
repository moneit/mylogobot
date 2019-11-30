export default { // this mixin is supposed to be used along with LogoPlacement mixin
    methods: {
        adjustScale() {
            let boundingScale = 1;
            if (this.boundingWidth !== 0 && this.boundingHeight !== 0) {
                let widthScale = this.width / this.boundingWidth;
                let heightScale = this.height / this.boundingHeight;
                boundingScale = Math.min(widthScale, heightScale);
            }

            /* container is now disabled
            let containerScale = 1;

            if (this.containerWidth !== 0 && this.containerHeight !== 0) {
                let widthScale = this.width / this.containerWidth;
                let heightScale = this.height / this.containerHeight;
                containerScale = Math.min(widthScale, heightScale);
            }
            */
            // this.scale = this.compact ? Math.min(boundingScale, containerScale) : Math.min(1, boundingScale, containerScale);

            this.scale = this.compact ? boundingScale : Math.min(1, boundingScale);
        },
    },
    watch: {
        previewSetting() {
            this.adjustScale();
        },
        boundingWidth() {
            this.adjustScale();
        },
        boundingHeight() {
            this.adjustScale();
        },
        containerWidth() {
            this.adjustScale();
        },
        containerHeight() {
            this.adjustScale();
        },
    },
    mounted() {
        this.adjustScale();
    },
}