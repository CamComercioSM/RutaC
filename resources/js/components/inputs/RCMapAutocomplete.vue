<template>
        <vue-google-autocomplete
                ref="address"
                :id="id"
                :name="name"
                classname="form-control"
                :placeholder="placeholder"
                v-on:placechanged="getAddressData"
                :rules="rules"
                :types="types"
                :initial-value="initialValue"
                :label="label"
        >
        </vue-google-autocomplete>
</template>

<script>
    import VueGoogleAutocomplete from './../VueGoogleAutocomplete.vue';

    export default {
        components: {
            VueGoogleAutocomplete,
        },
        props: {
            vid: {
                type: String
            },
            initialValue:{
                default: null,
            },
            error: {
                default: null,
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
            types: {
                type: String,
                default: 'address'
            },
            id: {
                type: String,
                default: null
            },
            keyValue: {
                type: String,
                default: null
            },
            name: {
                type: String,
                default: null
            },
            placeHolder: {
                type: String,
                default: null
            },
        },
        data: function () {
            return {
                address: '',
                value: null,
            }
        },
        created() {
            this.value = this.initialValue;
            this.clave = this.keyValue;
            this.placeholder = this.placeHolder;
        },
        mounted() {
            this.$refs.address.focus();
            if (this.error) {
                this.addError(this.error);
            }
        },
        methods: {
            /**
             * When the location found
             * @param {Object} addressData Data of the found location
             * @param {Object} placeResultData PlaceResult object
             * @param {String} id Input container ID
             */
            getAddressData: function (addressData, placeResultData, id) {
                this.address = addressData;

                let country = (addressData.country) ? addressData.country : '';
                let administrative = (addressData.administrative_area_level_1) ? addressData.administrative_area_level_1 : '';
                let locality = (addressData.locality) ? addressData.locality : '';

                document.getElementById('pais_'+this.clave).value = country;
                document.getElementById('departamento_'+this.clave).value = administrative;
                document.getElementById('municipio_'+this.clave).value = locality;
            },
        }
    }
</script>
