<template>
    <div>
        <span>
            Logo Bot is typing
        </span>
        <span class="spinner">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </span>
    </div>
</template>

<script>
    export default {
        name: "TypeInProgress"
    }
</script>

<style scoped>
    /*Huge thanks to @tobiasahlin at http://tobiasahlin.com/spinkit/ */
    .spinner {
        width: 30px;
        text-align: center;
    }

    .spinner > div {
        width: 0.5rem;
        height: 0.5rem;
        background-color: #333;

        border-radius: 100%;
        display: inline-block;
        -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
        animation: sk-bouncedelay 1.4s infinite ease-in-out both;
    }

    .spinner .bounce1 {
        -webkit-animation-delay: -0.32s;
        animation-delay: -0.32s;
    }

    .spinner .bounce2 {
        -webkit-animation-delay: -0.16s;
        animation-delay: -0.16s;
    }

    @-webkit-keyframes sk-bouncedelay {
        0%, 80%, 100% { -webkit-transform: scale(0) }
        40% { -webkit-transform: scale(1.0) }
    }

    @keyframes sk-bouncedelay {
        0%, 80%, 100% {
            -webkit-transform: scale(0);
            transform: scale(0);
        } 40% {
              -webkit-transform: scale(1.0);
              transform: scale(1.0);
          }
    }
</style>