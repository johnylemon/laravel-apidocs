<template>

    <div class="url">
        <method-badge :method="endpoint.method" />
        /{{ endpoint.uri }}
    </div>

</template>

<script>

import MethodBadge from '@/Method'

export default {
    props: ['endpoint'],
    components: {
        MethodBadge
    }
}

</script>
