<template>
    <DefaultLayout>
        <template v-slot:content>
            <div class="container pt-5 pb-3">
                checkout
            </div>
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