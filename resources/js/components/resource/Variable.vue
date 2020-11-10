<template>

    <div class="variable">
        <div>
            <div class="name">

                {{ name }}

                <div class="badges">
                    <span class="badge required" v-if="variable.required">required</span>
                    <span class="badge" :class="[variable.type]">{{ variable.type }}</span>
                </div>

            </div>

            <div class="description">
                {{ variable.description }}

                <ul>
                    <li>
                        <strong>Default:</strong>
                        <code>{{ variable.default }}</code>
                    </li>
                    <li>
                        <strong>Example:</strong>
                        <code>{{ variable.example }}</code>
                    </li>
                    <li>
                        <strong>Possible:</strong>
                        <code>{{ variable.possible }}</code>
                    </li>
                </ul>
            </div>
        </div>

        <code-editor :options="{
            lineNumbers: false
        }" :raw="true" @update="onUpdate" />

    </div>

</template>

<script>

import CodeEditor from '@/CodeEditor'

export default {
    props: ['variable', 'name'],
    components: {
        CodeEditor
    },
    computed: {
        isArray() {
            return this.variable.type == 'array'
        }
    },
    methods: {
        onUpdate(value) {
            this.$emit('update', this.formatValue(value))
        },
        jsonParsed(value) {
            try {
                return JSON.parse(value)
            }
            catch(e) {
                return ''
            }
        },
        formatValue(value) {
            let v = value.trim()
            return this.isArray ? this.jsonParsed(v) : v
        }
    }
}

</script>
