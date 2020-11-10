<template>

    <div>
        <slot />
        <codemirror v-model="codeFormatted" :options="options"  @input="onInput" />
    </div>

</template>

<script>

import { debounce } from 'lodash'

export default {
    props: ['code', 'options'],
    props: {
        code: {
            type: [Array, Object, String],
            default: ''
        },
        options: [Object],
        raw: {
            type: Boolean,
            default: false
        },
    },
    data() {
        return {
            codeFormatted: ''
        }
    },
    mounted() {
        this.codeFormatted = this.raw ? this.code : JSON.stringify(this.code, null, 4)
    },
    methods: {
        onInput(value) {
            this.$emit('update', value)
        }
    }
}

</script>
