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
            <b-form-select
                    v-bind="$attrs"
                    v-model="value"
                    :state="errors[0] ? false : null"
                    @change='getCities()'
            >
                <template v-slot:first v-if="placeholder">
                    <b-form-select-option :value="null" disabled>{{ placeholder }}</b-form-select-option>
                </template>
            </b-form-select>
            <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
        </b-form-group>
    </ValidationProvider>
</template>

<script>
    import { ValidationProvider } from "vee-validate";
    import EventBus from './event-bus.js';

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
            },
            placeholder: {
                type: String,
                default: null
            },
            subSelect: {
                default: null
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
                cities2: ''
            }
        },
        methods: {
            addError(error) {
                this.$refs.validationProvider.setErrors([this.error]);
            },
            getCities: function(){
                if(!this.value) {
                    this.value = this.initialValue;
                }
                document.getElementById(this.subSelect).childNodes[1].childNodes[0].disabled = true;
                let dependencia = this.subSelect;

                axios.get('https://rutadecrecimiento.com/public/buscar_municipios/'+this.value, {})
                    .then(function (response) {
                        EventBus.$emit('cities2', response.data);
                        document.getElementById(dependencia).childNodes[1].childNodes[0].disabled = false;
                    });
            }
        },
        created() {
            if (this.initialValue) {
                this.value = this.initialValue;
                this.getCities();
            }
        },
        mounted() {
            if (this.error) {
                this.addError(this.error);
            }
        }
    };
</script>