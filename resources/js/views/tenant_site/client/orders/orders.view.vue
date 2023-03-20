<template>
    <DefaultLayout>
        <template v-slot:content>
            <div class="container pt-5 pb-3">
                <div class="alert alert-warning text-center">
                    <strong> Tela de pedidos do clientes</strong>
                </div>
            </div>
        </template>
    </DefaultLayout>
</template>

<script>
import { mapActions } from "vuex";
import DefaultLayout from '../../layouts/tenant_site/DefaultLayout.vue';

export default {
    props: [],
    components: {
        DefaultLayout
    },
    data: () => ({}),
    computed: {},
    created() {},
    methods: {
    }
}
</script>