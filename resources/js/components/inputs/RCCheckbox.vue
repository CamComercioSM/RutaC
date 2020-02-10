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
                :label-for="$attrs.id"
        >
            <b-form-checkbox
                :vid="vid"
                v-model="status"
                :name="$attrs.name"
                :rules="rules"
                v-slot="{ errors }"
                value="true"
                unchecked-value="false"
            >
            {{ label }}
            </b-form-checkbox>
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
        methods: {
            addError(error) {
                this.$refs.validationProvider.setErrors([this.error]);
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