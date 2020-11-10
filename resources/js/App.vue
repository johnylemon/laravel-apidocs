<template>

    <div class="layout">
        <aside-menu class="aside"></aside-menu>
        <content-view class="content"></content-view>
    </div>

</template>

<script>

import AsideMenu from '@/aside/Menu'
import ContentView from '@/Content'

export default {

    data() {
        return {
        }
    },
    components: {
        AsideMenu,
        ContentView
    }

}

</script>
