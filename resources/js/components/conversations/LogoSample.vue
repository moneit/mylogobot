<template>
    <div class="row logo-samples-container">
        <div class="col-6 col-md-4" v-for="kind in kinds" :key="kind.id" v-if="beforeSelect || (!beforeSelect && kind.id === value.id)">
            <div class="h-100 d-flex flex-column justify-content-center">
                <input type="radio" :id="'logo_sample_' + kind.id" :value="kind" v-model="value" @click="onRadioClick" :disabled="disabled">
                <label :for="'logo_sample_' + kind.id" class="w-100 shadow pointer" style="border-radius: 1rem;padding: 20px; flex-grow: 1;">
                    <component :is="kind.component" class="w-100 h-100"></component>
                </label>
                <div class="text-center mt-2">
                    {{ kind.name }}
                </div>
            </div>
        </div>
        <div v-if="beforeSelect" class="col-6 d-md-none" @click="value = {}">
            <component is="LogoSampleSkip"></component>
        </div>
    </div>
</template>

<script>
    import LogoSampleIcon from '../logo_samples/Icon';
    import LogoSampleInitial from '../logo_samples/Initials';
    import LogoSampleTypography from '../logo_samples/Typography';
    import LogoSampleSkip from '../logo_samples/Skip';

    export default {
        name: "LogoSample",
        components: {
            LogoSampleIcon,
            LogoSampleInitial,
            LogoSampleTypography,
            LogoSampleSkip,
        },
        computed: {
            value: {
                get() {
                    return this.$store.state.kind;
                },
                set(value) {
                    this.updateValue(value);
                }
            },
            kinds() {
                return this.$store.state.kinds;
            },
            stage() {
                return this.$store.state.conversation.stage;
            },
            disabled() {
                return this.stage > 1;
            },
            beforeSelect() {
                return this.stage === 1;
            }
        },
        methods: {
            updateValue(value) {
                if (this.beforeSelect) {
                    this.$store.dispatch('updateKind', value);
                    this.$emit('send', value);
                }
            },
            onRadioClick($event) { // for SKIP element
                if (this.beforeSelect) {
                    if ($event.target._value.id === this.value.id) {
                        this.updateValue({});
                    }
                }
            }
        }
    }
</script>

<style scoped>
    .logo-samples-container {
        margin-top: 0.625rem;
        margin-bottom: 0.625rem;
    }
</style>