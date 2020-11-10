<template>

    <div class="tabs">
        <div class="header">
            <vue-custom-scrollbar class="scroll-area"  :settings="settings">
                <div
                    v-for="(item, index) in items" :key="index"
                    class="tab"
                    :class="{'current': index == current}"
                    @click="select(index)" >
                    {{ itemTitle(item.title, index)  }}
                </div>
            </vue-custom-scrollbar>

        </div>
        <div class="content">
            <code-editor
                v-for="(item, index) in items"
                v-if="current == index"
                :key="index"
                :code="item.data"
                :options="{ readOnly: true }" />
        </div>
    </div>

</template>

<script>

import CodeEditor from '@/CodeEditor'
import vueCustomScrollbar from 'vue-custom-scrollbar'

export default {
    props: {
        items: {
            type: Array,
            default: []
        }
    },
    data() {
        return {
            exampleText: "example",
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
    computed: {
    },
    methods: {
        itemTitle(text, index) {
            return text || `${this.exampleText} ${index + 1}`
        },
        select(index) {
            this.current = index
        }
    }
}

</script>
