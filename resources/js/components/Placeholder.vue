<template>

    <div class="placeholder">
        <slot/>
    </div>

</template>

<style lang="sass" scoped>

    .placeholder
        background: rgba(0,0,0,0.1)
        min-height: 100px
        display: flex
        align-items: center
        justify-content: center

</style>

<script>

export default {
}

</script>
