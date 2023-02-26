<template>
    <DefaultLayout>
        <template v-slot:content>
            home client vue
        </template>
    </DefaultLayout>
</template>

<script>
import DefaultLayout from '../../layouts/tenant_site/DefaultLayout.vue';

export default {
    props: [],
    components: {
        DefaultLayout
    },
    data: () => ({}),
    computed: {},
    mounted() { },
    methods: {}
}
</script>