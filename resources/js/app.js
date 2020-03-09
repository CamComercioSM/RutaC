require('./bootstrap');
require('./font-awesome');
require('./vee-validate');
//require('./eventBus');

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
import RCSelectCity from "./components/inputs/RCSelectCity";
import RCRadio from "./components/inputs/RCRadio";

Vue.component('rc-select', RCSelect);
Vue.component('rc-input', RCInput);
Vue.component('rc-checkbox', RCCheckbox);
Vue.component("rc-alert", RCAlert);
Vue.component('rc-select-location', RCSelectLocation);
Vue.component('rc-select-city', RCSelectCity);
Vue.component('rc-radio', RCRadio);

// Custom forms
import RCForm from "./components/forms/RCForm";

Vue.component('rc-form', RCForm);

Vue.prototype.$eventHub = new Vue();

const app = new Vue({
    el: '#app',
});