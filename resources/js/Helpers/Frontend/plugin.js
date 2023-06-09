import Vue from 'vue';

// ===============Login helpers=============
import User from "./../Login/User";
window.User = User;

// ===============Pagination===============
import Pagination from './../../components/backend/elements/Pagination'
Vue.component('Pagination', Pagination)

// ===============Spinner===============
import Spinner from './../../components/frontend/elements/Spinner'
Vue.component('Spinner', Spinner)

// ===============Input===============
import Input from './../../components/backend/elements/Form/Input'
Vue.component('Input', Input)

// ===============Select===============
import Select from './../../components/backend/elements/Form/Select'
Vue.component('Select', Select)

// ===============SelectCustom===============
import SelectCustom from './../../components/backend/elements/Form/SelectCustom'
Vue.component('SelectCustom', SelectCustom)

// ===============Radio===============
import Radio from './../../components/backend/elements/Form/Radio'
Vue.component('Radio', Radio)

// ===============Textarea===============
import Textarea from './../../components/backend/elements/Form/Textarea'
Vue.component('Textarea', Textarea)

// ===============Breadcrumbs from vuex===============
import breadcrumbs from "../../vuex/breadcrumbs_frontend";
window.frontBreadcrumbs = breadcrumbs;

// ===============VueLazyload===============
import VueLazyload from 'vue-lazyload'
Vue.use(VueLazyload, {
    listenEvents: ['scroll', 'wheel', 'mousewheel', 'resize', 'animationend', 'transitionend']
})

// ===============js pdf===============
import jsPDF from 'jspdf';
window.jsPDF = jsPDF;
import autoTable from 'jspdf-autotable'
window.autoTable = autoTable;

// ===============Flash Message===============
import FlashMessage from '@smartweb/vue-flash-message';
Vue.use(FlashMessage);

import BootstrapVue from 'bootstrap-vue'
Vue.use(BootstrapVue);
import IconsPlugin from "bootstrap-vue/dist/bootstrap-vue.css";
Vue.use(IconsPlugin);


// ===============Simple Vue Validator===============
import SimpleVueValidation from "simple-vue-validator";
const Validator = SimpleVueValidation.Validator;
window.Validator = Validator;
Vue.use(SimpleVueValidation);



import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);


// ===============Vue Select===============
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
Vue.component('v-select', vSelect)
