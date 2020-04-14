<template>
    <v-stepper :steps="steps" v-model="step"></v-stepper>
</template>

<script>
    import { VStepper } from 'vue-stepper-component'

    export default {
        components: {
            VStepper
        },
        data() {
            return {
                steps: 4,
                step: undefined,
            }
        },
    }
</script>
