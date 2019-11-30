export default {
  computed: {
    compoundLoadingProperty() {
      return [this.transform, this.containerTransform, this.symbolTransform, this.companyNameTransform, this.sloganTransform].join()
    }
  },
  methods: {
    checkRenderingUsingRecursivePromise() {
      return new Promise((resolve, reject) => {
        if (this.previewFail) {
          this.$emit('rendering-completed');
          resolve();

          return;
        }

        let oldValue = this.compoundLoadingProperty;
        setTimeout(() => {
          if (
            // this.containerApiCompleted &&
            this.symbolApiCompleted && this.companyNameApiCompleted && this.sloganApiCompleted && oldValue === this.compoundLoadingProperty) {
            this.$emit('rendering-completed');

            resolve();
          } else {
            resolve(this.checkRenderingUsingRecursivePromise());
          }
        }, 500);
      });
    },
  },
  mounted() {
    this.checkRenderingUsingRecursivePromise();
  },
}