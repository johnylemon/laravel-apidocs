<template>

    <a @click="markActive" :href="anchor" class="menu-item scrollactive-item" :class="classes">
        <method-badge class="badge" :method="endpoint.method" />{{ endpoint.title }}
    </a>

</template>

<script>

import MethodBadge from '@/Method'

export default {
    props: ['endpoint'],
    data() {
        return {
        }
    },
    components: {
        MethodBadge
    },
    computed:{
        currentUri() {
            return this.$store.getters['currentUri']
        },
        anchor() {
            return `#${this.endpoint.id}`
        },
        classes() {
            return {
                deprecated: this.endpoint.deprecated
            }
        }
    },
    methods: {
        markActive() {
            this.$store.commit('currentUri', this.endpoint.id)
        }
    }
}

</script>
