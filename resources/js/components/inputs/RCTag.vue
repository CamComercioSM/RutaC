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

            <b-form-tags v-bind="$attrs" v-model="value" size="lg" add-on-change no-outer-focus class="mb-2">
                <template v-slot="{ tags, inputAttrs, inputHandlers, disabled, removeTag }">
                    <ul v-if="tags.length > 0" class="list-inline d-inline-block mb-2">
                        <li v-for="tag in tags" :key="tag" class="list-inline-item">
                            <b-form-tag
                                    @remove="removeTag(tag)"
                                    :disabled="disabled"
                                    :state="errors[0] ? false : null"
                                    class="mb-2"
                            >{{ tag }}</b-form-tag>
                        </li>
                    </ul>
                    <b-form-select
                            v-bind="inputAttrs"
                            v-on="inputHandlers"
                            :disabled="disabled || availableOptions.length === 0"
                            :options="availableOptions"
                    >
                        <template v-slot:first v-if="placeholder">
                            <option value="" disabled>{{ placeholder }}</option>
                        </template>
                    </b-form-select>
                </template>
            </b-form-tags>

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
                type: Array,
                default: null,
            },
            placeholder: {
                type: String,
                default: null
            },
            options: {
                type: Array,
                default: null,
            }

        },
        computed: {
            formGroupID: function() {
                return 'fieldset-for-' + this.$attrs.id;
            },
            availableOptions() {
                if(this.value == null){
                    return this.options;
                }
                return this.options.filter(opt => this.value.indexOf(opt) === -1);
            }
        },
        data: function() {
            return {
                value: []
            }
        },
        methods: {
            addError(error) {
                this.$refs.validationProvider.setErrors([this.error]);
            },
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
