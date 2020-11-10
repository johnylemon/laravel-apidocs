<template>
    <div class="method-badge" :class="classes">
        {{ method }}
    </div>
</template>

<script>

export default {
    props: ['method'],
    computed: {
        classes() {
            return {
                [this.method.toLowerCase()]: true,
            }
        }
    }
}

</script>
