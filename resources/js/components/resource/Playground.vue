<template>

    <div class="playground">

        <div class="tabs">
            <div class="header">
                <vue-custom-scrollbar class="scroll-area"  :settings="settings">
                <div
                    v-for="(type, index) in types"
                    :key="index"
                    :class="{current: type == currentTab }"
                    @click="currentTab = type"
                    class="tab">{{ type }}</div>
                </vue-custom-scrollbar>
            </div>
            <div class="content" style="padding-top: 2rem">
                <variables
                    v-show="currentTab == 'route'"
                    @update="onUpdate($event, 'route')"
                    :variables="routeParams" />
                <variables
                    v-show="currentTab == 'body'"
                    @update="onUpdate($event, 'body')"
                    :variables="bodyParams" />
                <variables
                    v-show="currentTab == 'query'"
                    @update="onUpdate($event, 'query')"
                    :variables="queryParams" />

                <code-editor
                    v-if="currentTab == 'headers'"
                    @update="onUpdateHeaders($event)"
                    :code="fetch.headers" />
            </div>
        </div>

        <div class="try-it">
            <div class="header">
                <div class="button" @click="tryIt()">Try it</div>
            </div>
            <codemirror v-model="curl" :options="options" />
            <try-response v-if="response" :response="response" />
        </div>

    </div>

</template>

<script>

import Variables from '@/resource/Variables'
import CodeEditor from '@/CodeEditor'
import TryResponse from '@/TryResponse'
import fetchToCurl from 'fetch-to-curl'
import vueCustomScrollbar from 'vue-custom-scrollbar'
import qs from 'qs'
import axios from 'axios'
import { get, isEmpty, replace, forEach } from 'lodash'

export default {
    props: ['endpoint'],
    components: {
        Variables,
        CodeEditor,
        TryResponse,
        vueCustomScrollbar
    },
    data() {
        return {
            //
            // codemirror options
            //
            options: {
                mode: 'shell',
            },

            //
            // variable tabs
            //
            currentTab: 'route',
            types: ['route', 'query', 'body', 'headers'],

            //
            // variables and cURL result
            //
            curl: '',
            fetch: {
                headers: get(this.endpoint, `headers`, {}),
                body: {},
                query: {},
                route: {},
            },

            //
            // scrollbar settings
            //
            settings: {
                suppressScrollY: true,
                suppressScrollX: false,
                wheelPropagation: true
            },
            //
            // try it response
            //
            response: null
        }
    },
    mounted() {
        this.buildCurl()
    },
    computed: {
        bodyParams() {
            return get(this.endpoint, `body.data`, [])
        },
        queryParams() {
            return get(this.endpoint, `query`, [])
        },
        routeParams() {
            return get(this.endpoint, `params`, [])
        },
    },
    methods: {
        parseJson(value, defaultValue = {}) {
            try {
                return JSON.parse(value)
            }
            catch(e) {
                return defaultValue
            }
        },
        fullUrl() {
            let url = [window.root, this.parsedUri()].join('/')

            if(!isEmpty(this.fetch.query))
            {
                let queryString = qs.stringify(this.fetch.query);
                url = `${url}?${queryString}`
            }

            return url
        },
        parsedUri() {

            let result = this.endpoint.uri;

            forEach(this.fetch.route, (value, key) => {
                result = replace(result, `{${key}}`, value)
            })

            return result
        },
        onUpdate(value, name) {
            if(value)
                this.fetch[name] = value
            else
                delete this.fetch[name]

            this.buildCurl()
        },
        onUpdateHeaders(value) {
            this.onUpdate(this.parseJson(value), 'headers')
        },
        buildCurl() {

            let options = {
                method: this.endpoint.method,
            }

            if(!isEmpty(this.fetch.body))
                options['body'] = this.fetch.body

            if(!isEmpty(this.fetch.headers))
                options['headers'] = this.fetch.headers

            this.curl = this.formatLines(fetchToCurl(this.fullUrl(), options))
        },
        formatLines(value) {
            try {
                return value.replaceAll(' -', ' \\\n\t -')
            }
            catch(e) {
                return ''
            }
        },
        tryIt() {
            this.response = null

            axios({
                method: this.endpoint.method,
                url: this.fullUrl(),
                headers: Object.assign(this.fetch.headers, {
                    [window.header_name]: 1,
                }),
                data: this.fetch.body
            })
            .then((response) => {
                this.response = response
            })
            .catch((error) => {
                this.response = error.response
            })
        }
    }
}

</script>
