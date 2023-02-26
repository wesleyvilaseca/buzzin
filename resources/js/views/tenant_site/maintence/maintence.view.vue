<template>
    <DefaultLayout>
        <template v-slot:content>
            <div class="container pt-5 pb-3">
                <div class="alert alert-warning text-center">
                    <strong> Site em Manutenção</strong>
                </div>
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