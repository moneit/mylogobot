<template>
    <g class="logo-group" id="logo-container" :style="{opacity: opacity}" :fill="color" ref="container"></g>
</template>

<script>
  import containerApi from '../../../services/api/containers';

  export default {
    name: "Container",
    props: {
      previewMode: {
        type: Boolean,
        default: function() {
          return false;
        }
      },
      previewSettings: {
        type: Object,
        default: function() {
          return {}
        },
      },
      previewFail: {
        type: Boolean,
        default: function() {
          return false;
        }
      },
    },
    data() {
      return  {
        module: 'container',
      };
    },
    mounted() {
      this.drawShapes();

      if (this.previewMode) {
        if (this.previewSettings.selected && this.previewSettings.selected.id) {
          this.getPreviewShapes()
            .finally(() => {
              this.$emit('api-completed');
            });
        }
      }
    },
    computed: {
      color() {
        if (this.previewMode) {
          return this.previewSettings.color.hex;
        }
        return this.$store.state[this.module].color.hex;
      },
      opacity() {
        if (this.previewMode) {
          return this.previewSettings.color.a;
        }
        return this.$store.state[this.module].color.a;
      },
      shapes() {
        if (this.previewMode) {
          return this.previewSettings.shapes;
        }
        return this.$store.state[this.module].shapes;
      },
    },
    methods: {
      removeShapes() {
        let container = this.$refs.container;
        while (container.firstChild) {
          container.removeChild(container.firstChild);
        }
      },
      drawShapes() {
        let container = this.$refs.container;
        this.shapes.forEach((shape) => {
          if (shape['tag']) {
            let node = document.createElementNS("http://www.w3.org/2000/svg", shape['tag']);
            for(let attr in shape) {
              if (attr !== 'tag') {
                node.setAttributeNS(null, attr, shape[attr]);
              }
            }
            container.appendChild(node);
          }
        });
      },
      getPreviewShapes() {
        return containerApi.getData({
          id: this.previewSettings.selected.id
        }, (data) => {
          if (data.status === 'success') {
            this.previewSettings.viewBox = data.payload.viewBox;
            this.previewSettings.shapes = data.payload.shapes;
          }
        });
      },
    },
    watch: {
      shapes() {
        this.removeShapes();
        this.drawShapes();
      }
    }
  }
</script>

<style scoped>

</style>