<template>
    <div class="menu-group">
        <div class="title">{{ group.name }}:</div>
        <menu-item v-for="(endpoint, index) in items" :key="index" :endpoint="endpoint"></menu-item>
    </div>
</template>

<script>

import MenuItem from '@/aside/menu/Item'

export default {
    props: ['name', 'items'],
    components: {
        MenuItem
    },
    computed: {
        group() {
            return this.$store.getters['groups'][this.name]
        },
        // endpoints() {
        //     return this.$store.getters['groupEndpoints'](this.name)
        // },
    }
}

</script>
