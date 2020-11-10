<template>

    <div class="content-view">

        <div class="hero">
            <div class="desc">
                <h2>{{ info.title }}</h2>
                <p>{{ info.description }}</p>

                <small>
                    ver: <strong>{{ info.version }}</strong>
                </small>
                <div></div>
                <small>
                    host: <strong>{{ host }}</strong>
                </small>
            </div>
        </div>

        <resource v-for="(endpoint, index) in endpoints" :key="index" :endpoint="endpoint"></resource>
    </div>

</template>

<script>

import Resource from '@/Resource'

export default {
    components: {
        Resource
    },
    data() {
        return {
            info: window.info,
            host: window.root
        }
    },
    computed: {
        endpoints() {
            return this.$store.getters['endpoints']
        }
    },
}

</script>
