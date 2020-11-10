<template>

    <div class="tryit-result">

        <div class="block">
            <div class="status" :class="[`status-${response.status}`]">
                <b>{{ response.status }}</b>: {{ response.statusText }}
            </div>
        </div>
        <code-editor :code="response.data" :options="{ readOnly: true }" />
    </div>

</template>

<script>

import CodeEditor from '@/CodeEditor'

export default {
    props: ['response'],
    data() {
        return {
        }
    },
    components: {
        CodeEditor
    }
}

</script>
