require('./bootstrap');
require('./font-awesome');
require('./vee-validate');

window.Vue = require('vue');

// Bootstrap-vue
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

// Custom components
import RCSelect from "./components/inputs/RCSelect";
import RCInput from "./components/inputs/RCInput";
import RCCheckbox from "./components/inputs/RCCheckbox";
import RCAlert from "./components/RCAlert";
import RCSelectLocation from "./components/inputs/RCSelectLocation";

Vue.component('rc-select', RCSelect);
Vue.component('rc-input', RCInput);
Vue.component('rc-checkbox', RCCheckbox);
Vue.component("rc-alert", RCAlert);
Vue.component('rc-select-location', RCSelectLocation);

// Custom forms
import RCForm from "./components/forms/RCForm";

Vue.component('rc-form', RCForm);

const app = new Vue({
    el: '#app',
});
