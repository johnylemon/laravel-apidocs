<template>

    <div class="variables">

        <variable
            v-for="(v, index) in variables"
            :key="index"
            :name="index"
            :variable="v"

            @update="onUpdate($event, index)"
             />

    </div>

</template>

<script>

import { get } from 'lodash'
import Variable from '@/resource/Variable'

export default {
    props: ['variables'],
    components: {
        Variable
    },
    data() {
        return {
            values: {}
        }
    },
    methods: {
        onUpdate(value, name) {
            if(value)
                this.values[name] = value
            else
                delete this.values[name]

            this.$emit('update', this.values)
        }
    }
}

</script>
