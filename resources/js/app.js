import RCDatePicker from "./components/inputs/RCDatePicker";
import RCStepper from "./components/stepper/RCStepper";

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
import RCSelectLocation2 from "./components/inputs/RCSelectLocation2";
import RCSelectCity from "./components/inputs/RCSelectCity";
import RCSelectCity2 from "./components/inputs/RCSelectCity2";
import RCRadio from "./components/inputs/RCRadio";
import RCTag from "./components/inputs/RCTag";
import RCInputMoney from "./components/inputs/RCInputMoney";

Vue.component('rc-select', RCSelect);
Vue.component('rc-input', RCInput);
Vue.component('rc-checkbox', RCCheckbox);
Vue.component("rc-alert", RCAlert);
Vue.component('rc-select-location', RCSelectLocation);
Vue.component('rc-select-location-2', RCSelectLocation2);
Vue.component('rc-select-city', RCSelectCity);
Vue.component('rc-select-city-2', RCSelectCity2);
Vue.component('rc-radio', RCRadio);
Vue.component('rc-date-picker', RCDatePicker);
Vue.component('rc-tag', RCTag);
Vue.component('rc-stepper', RCStepper);
Vue.component('rc-input-money', RCInputMoney);

// Custom forms
import RCForm from "./components/forms/RCForm";

Vue.component('rc-form', RCForm);

Vue.prototype.$eventHub = new Vue();

const app = new Vue({
    el: '#app',
});
