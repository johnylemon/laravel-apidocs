<template>

    <div class="tabs">
        <div class="header">
                <vue-custom-scrollbar class="scroll-area"  :settings="settings">
                <div
                    v-for="(item, index) in items"
                    :key="index"
                    class="tab"
                    :class="{'current': index == current}"
                    @click="select(index)" >
                    {{ index }}
                </div>
            </vue-custom-scrollbar>

        </div>
        <div class="content">
            <code-editor
                v-for="(item, index) in items"
                v-if="current == index"
                :key="index"
                :code="item.response"
                :options="{ readOnly: true }">
                {{ item.description }}
            </code-editor>
        </div>
    </div>

</template>

<style lang="sass">
    .tabs
        padding-left: 1rem
</style>

<script>

import CodeEditor from '@/CodeEditor'
import { first } from 'lodash'
import vueCustomScrollbar from 'vue-custom-scrollbar'

export default {
    props: ['items'],
    data() {
        return {
            current: 0,
            settings: {
                suppressScrollY: true,
                suppressScrollX: false,
                wheelPropagation: true
            }
        }
    },
    components: {
        CodeEditor,
        vueCustomScrollbar
    },
    mounted() {
        this.current = Object.keys(this.items)[0]
    },
    methods: {
        select(index) {
            this.current = index
        }
    }
}

</script>
