<template>

    <div :id="anchor" class="resource" :class="classes">
        <div class="title">
            {{ endpoint.title }}
        </div>
        <div class="description desc">
            {{ endpoint.description }}
        </div>
        <url :endpoint="endpoint" />

        <div class="samples">
            <examples v-if="size(examples)" :items="examples" />
            <placeholder v-else>No examples</placeholder>

            <responses v-if="size(responses)" :items="responses" />
            <placeholder v-else>No examples</placeholder>
        </div>

        <playground :endpoint="endpoint" />
    </div>

</template>

<script>

import Placeholder from '@/Placeholder'
import Examples from '@/resource/Examples'
import Responses from '@/resource/Responses'
import Playground from '@/resource/Playground'
import Url from '@/resource/Url'
import { size } from 'lodash'

export default {
    props: ['endpoint'],
    components: {
        Placeholder,
        Examples,
        Responses,
        Playground,
        Url,
    },
    computed: {
        examples() {
            return this.endpoint.examples || []
        },
        responses() {
            return this.endpoint.returns || []
        },
        anchor() {
            return `${this.endpoint.id}`
        },
        classes() {
            return {
                'deprecated': this.endpoint.deprecated
            }
        }
    },
    methods: {
        size(value) {
            return size(value)
        }
    }
}

</script>
