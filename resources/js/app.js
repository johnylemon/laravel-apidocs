import Vue from "vue";
import store from "./store";
import App from './App.vue';


// vue scrollbar styles
import "vue-custom-scrollbar/dist/vueScrollbar.css"

import VueScrollactive from 'vue-scrollactive'
Vue.use(VueScrollactive);

import VueCodeMirror from 'vue-codemirror'

// import base style
import 'codemirror/mode/javascript/javascript.js'
import 'codemirror/mode/shell/shell.js'
import 'codemirror/lib/codemirror.css'
import 'codemirror/theme/monokai.css'

Vue.use(VueCodeMirror, {
    options: {
        indentWithTabs: true,
        tabSize: 4,
        lineNumbers: true,
        smartIndent: false,
        scrollbarStyle: 'native',
        theme: 'monokai',
        mode: 'text/javascript',
    },
})

window.vue = new Vue({
  store,
  render: h => h(App)
}).$mount("#app");
