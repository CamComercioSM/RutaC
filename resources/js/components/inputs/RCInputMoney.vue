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
            <b-form-input
                    v-bind="$attrs"
                    v-model="value"
                    :state="errors[0] ? false : null"
                    @change="formatCurrency(value)"
            />
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
                default: null,
            }
        },
        computed: {
            formGroupID: function() {
                return 'fieldset-for-' + this.$attrs.id;
            }
        },
        data: function() {
            return {
                value: null,
            }
        },
        methods: {
            addError(error) {
                this.$refs.validationProvider.setErrors([this.error]);
            },
            formatNumber(n) {
                return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
            formatCurrency(n) {
                let num = parseFloat(n).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                document.getElementById(this.$attrs.id).childNodes[1].childNodes[0].value = num;
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
    };
</script>