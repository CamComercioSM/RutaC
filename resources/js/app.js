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

Vue.component('rc-select', RCSelect);
Vue.component('rc-input', RCInput);

const app = new Vue({
    el: '#app',
});
