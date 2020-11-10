import Vue from "vue";
import Vuex from "vuex";
import { filter } from 'lodash'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        apidocs: window.apidocs,
        colormap: {
            get: 'teal',
            post: 'orange',
            patch: 'blue',
            put: 'pink',
            delete: 'red',
            options: 'gray',
        },
        currentUri: window.location.hash.replace('#', ''),
        try: {},
    },
    getters: {
        colormap (state) {
            return state.colormap
        },
        groups (state) {
            return state.apidocs.groups
        },
        currentUri (state) {
            return state.currentUri
        },
        endpoints (state) {
            return state.apidocs.endpoints
        },
        groupEndpoints: (state) => (name) => {
            return filter(state.apidocs.endpoints, (item) => { return item.group == name })
        }
    },
    mutations: {

        currentUri (state, payload) {
            state.currentUri = payload
        }

        // addTry (state, key) {
        //     Vue.set(state.try, key, {
        //         param: {},
        //         query: {},
        //         body: {},
        //         headers: {},
        //     })
        // }

        // setTry (state, payload) {
        //     state.try[payload.key] = value
        //     Vue.set(state.try, key, {
        //         param: {},
        //         query: {},
        //         body: {},
        //         headers: {},
        //     })
        // }

    },
    actions: {}
});
