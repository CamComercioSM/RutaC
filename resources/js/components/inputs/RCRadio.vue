<template>
    <ValidationProvider
            ref="validationProvider"
            :vid="vid"
            :name="$attrs.name"
            :rules="rules"
            v-slot="{ errors }"
            slim
    >
        <b-form-group
                :id="formGroupID"
                :description="description"
                :label="label"
                :label-for="$attrs.id"
        >
            <b-form-radio
                    :vid="vid"
                    v-model="value"
                    :name="$attrs.name"
                    :rules="rules"
                    :state="errors[0] ? false : null"
                    value=""
            >
                {{ text }}
            </b-form-radio>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
        </b-form-group>
    </ValidationProvider>
</template>

<script>
    import { ValidationProvider } from "vee-validate";

    export default {
        components: {
            ValidationProvider
        },
        props: {
            vid: {
                type: String
            },
            rules: {
                type: [Object, String],
                default: ""
            },
            label: {
                type: String,
                default: null
            },
            text: {
                type: String,
                default: null
            },
            description: {
                type: String,
                default: null,
            },
            error: {
                default: null,
            },
            initialValue:{
                default: false,
            }
        },
        computed: {
            formGroupID: function() {
                return 'fieldset-for-' + this.$attrs.id;
            }
        },
        data() {
            return {
                status: 'false'
            }
        },
        created() {
            this.value = this.initialValue;
        },
        mounted() {
            if (this.error) {
                this.addError(this.error);
            }
        }
    }
</script>