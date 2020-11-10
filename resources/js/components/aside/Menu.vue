<template>

    <div class="aside">
        <div class="pb-4">
            <input v-model="queryString" type="search" class="w-full block bg-purple-white shadow rounded border-0 p-1 px-3 outline-none bg-red-darker" placeholder="Search">
        </div>

        <scrollactive active-class="active" :offset="80">
            <menu-group v-for="(group, slug) in groupped" :key="slug" :name="slug" :items="group"></menu-group>
        </scrollactive>

    </div>

</template>

<script>

import MenuGroup from '@/aside/menu/Group'
import { groupBy, filter } from 'lodash'

export default {
    props: [],
    data() {
        return {
            queryString: ''
        }
    },
    components: {
        MenuGroup
    },
    computed: {
        endpoints() {
            return this.$store.getters['endpoints']
        },
        query() {
            return this.queryString.toLowerCase()
        },
        filtered() {
            return filter(this.endpoints, (endpoint) => {
                return endpoint.title.toLowerCase().includes(this.query)
            })
        },
        groupped() {
            return groupBy(this.filtered, 'group')
        },
    }
}

</script>
