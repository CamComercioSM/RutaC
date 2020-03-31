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
            <b-input-group class="mb-3">
                <b-form-input
                        id="example-input"
                        v-model="value"
                        type="text"
                        placeholder="YYYY-MM-DD"
                ></b-form-input>
                <b-input-group-append>
                    <b-form-datepicker
                            v-bind="$attrs"
                            v-model="value"
                            :state="errors[0] ? false : null"
                            button-only
                            aria-controls="example-input"
                            :date-format-options="{ year: 'numeric', month: 'numeric', day: 'numeric' }"
                    ></b-form-datepicker>
                    <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                </b-input-group-append>
            </b-input-group>
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
                dafault: null
            },
            description: {
                type: String,
                default: null,
            },
            error: {
                default: null,
            },
            initialValue: {
                default: null,
            }
        },
        computed: {
            formGroupID: function () {
                return 'fieldset-for-' + this.$attrs.id;
            }
        },
        data: function () {
            return {
                value: null,
            }
        },
        methods: {
            addError(error) {
                this.$refs.validationProvider.setErrors([this.error]);
            }
        },
        created() {
            if (this.initialValue) {
                this.value = this.initialValue;
            }
        },
        mounted() {
            if (this.error) {
                this.addError(this.error);
            }
        }
    };
</script>
