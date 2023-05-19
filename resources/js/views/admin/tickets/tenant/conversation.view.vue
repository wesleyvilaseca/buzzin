<template>

</template>

<script>

export default {
    props: {
        ticket_id: Number
    },
    components: {},
    data: () => ({
        loding: false,
        modal: 'none',
        tickets: [],
        form: {
            ticket_type_id: "",
            description: "",
            message: ""
        },
        errors: {
            ticket_type_id: "",
            description: "",
            message: ""
        }
    }),
    computed: {},
    computed: {},
    mounted() {
    },
    methods: {}
}
</script>