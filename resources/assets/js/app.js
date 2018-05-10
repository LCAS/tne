
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.defaults.withCredentials = true;

let token = document.head.querySelector('meta[name="csrf-token"]');
window.tne_base_path = document.head.querySelector('meta[name="tne_base_path"]').content;

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

window.Vue = require('vue');

import 'babel-polyfill'
import VueClipboards from 'vue-clipboards';
import conditionalSelect from './components/ConditionalSelect.vue';
import resourceBox from './components/ResourceBox.vue';
import criteriaBox from './components/CriteriaBox.vue';
import collapseBox from './components/CollapseBox.vue';
import linkAdder from './components/LinkAdder.vue';
import flash from './components/Flash.vue';

Vue.component('conditional-select', conditionalSelect);
Vue.component('resource-box', resourceBox);
Vue.component('criteria-box', criteriaBox);
Vue.component('collapse-box', collapseBox);
Vue.component('link-adder', linkAdder);
Vue.component('flash', flash);

Vue.use(VueClipboards);

window.events = new Vue({ el:'footer' });

window.flash = function(message, type) {
    window.events.$emit('flash', message, type);
};

const app = new Vue({
    el: '#app',
    data: {
        table_data: {'selected': [], 'linked': [] },
        table_loading: false,
        countries: [],
        programmes: [],
        modules: [],
        hideNoLinks: false
    },
    computed: {
        criterialist: function() {
            return Array.prototype.join.call(this.table_data.selected, "\n");
        },
        linkedlist: function() {
            return Array.prototype.join.call(this.table_data.linked, "\n");
        },
        showCopy: function() {
            return this.criterialist && !this.table_loading;
        },
        noLinks: function() {
            return !this.table_loading && !this.table_data.linked.length && this.hideNoLinks ;
        },
        noCriteria: function() {
            return !this.table_loading && !this.table_data.selected.length && this.hideNoLinks;
        }
    },
    methods: {
        updatetable (val) {
            this.table_data = {'selected': [], 'linked': [] };
            if (val != "") {
                this.table_loading = true;
                axios.get(window.tne_base_path + '/table-data/' + val)
                .then((response) => {
                    this.table_data = response.data;
                    this.hideNoLinks = true;
                    this.table_loading = false;
                })
                .catch((error) => {
                    this.table_loading = false;
                    flash("Opps! Something went wrong!", 'error');
                });
            } else {
                this.hideNoLinks = false;
            }
        },
        copySuccess(e) {
            window.flash('Copied to clipboard', 'success');
        },
        copyError(e) {
            window.flash('We could not copy to your clipboard','error');
        }
    },
    directives: {
        'resource-focus' (el, binding) { if (binding.value) el.focus() } }
});
