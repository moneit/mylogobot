<template>
    <div class="loader-container">
        <div class="loader-overlay">
            <div class="h-100 d-flex flex-column justify-content-center align-items-center">
                <img src="img/bot-working.png" />
                <div class="progress w-25">
                    <div class="progress-bar progress-bar-striped progress-bar-animated background-primary" role="progressbar" :style="styles" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <h3 class="mt-3 color-primary">
                    {{ text }}
                </h3>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: "BotLoader",
    props: {
      fakeProgress: {
        type: Boolean,
        default: function() {
          return false;
        }
      },
    },
    data() {
      return {
        progress: 0,
        texts: [
          'I’ve started cooking your brand-new logo.',
          'I’m mixing all of the ingredients.',
          'Nah. I’m just throwing a party with robots!',
          'I’m now taking the information you’ve provided to become even smarter next time.',
          'I’m now making your logo LEGENDARY!',
          'Aiming for Perfection!',
          'Spicing up with tons of Creativity.',
          'In a call with Sophia.',
          'Preparing dinner for my AI friends. Yes, we eat.',
        ],
        iteration: 0,
        text: '',
        intervalId: null,
        logosProgressTimeInSecond: 30,
        logosLoadingTimeInSecond: 3,
        stepsPerSecond: 25,
      }
    },
    computed: {
      recommendationsLoading() {
        return this.$store.getters['recommendation/loading'];
      },
      styles() {
        return { width: this.progress + '%'}
      },
      logosLoadingTimeInMilliSecond() {
        return this.logosLoadingTimeInSecond * 1000;
      },
      stepsForFakeProgress() {
        return this.stepsPerSecond * this.logosProgressTimeInSecond;
      },
      fakeProgressAdvancePerStep() {
        return 100 / 2 / (this.stepsForFakeProgress);
      },
      stepsForRealProgress() {
        return this.stepsPerSecond * this.logosLoadingTimeInSecond;
      },
      realProgressAdvancePerStep() {
        return 100 / 2 / (this.stepsForRealProgress);
      },
      intervalForStep() {
        return 1000 / this.stepsPerSecond;
      },
    },
    methods: {
      startFakeProgress() {
        if (this.intervalId) window.clearInterval(this.intervalId);

        this.intervalId = window.setInterval(() => {
          this.iteration++;
          this.iteration = this.iteration % (this.stepsForFakeProgress);

          this.progress += this.fakeProgressAdvancePerStep;

          if (this.progress >= 50) { // passed half of progress bar
            this.progress = 50;
          }
          this.text = this.texts[Math.floor( this.iteration / Math.ceil(this.stepsForFakeProgress / this.texts.length) )];
        }, this.intervalForStep);
      },
      startRealProgress() {
        if (this.intervalId) window.clearInterval(this.intervalId);

        this.text = 'Wow. You’ll love these logos!';

        this.intervalId = window.setInterval(() => {
          this.progress += this.realProgressAdvancePerStep;
          if (this.progress >= 100) {
            this.progress = 100;
          }
        }, this.intervalForStep);
      },
    },
    watch: {
      fakeProgress(value) {
        if (value) {
          this.progress = 0;
          this.iteration = 0;
          this.startFakeProgress();
        } else {
          window.clearInterval(this.intervalId);
          this.startRealProgress();
        }
      },
    },
    beforeDestroy() {
      if (this.intervalId) window.clearInterval(this.intervalId);
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
        background-color: white;
    }
</style>