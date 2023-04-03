<template>
    <div class="card p-0 ms-2" style="width: 11rem;" @click="redirect()">
        <div class="card-body text-center brand_card">
            <div class="card-title">
                <small>Uma plataforma</small>
            </div>
            <p class="card-text">
            <h5 class="fw-bold">Buzz<span class="fw-bold" style="color:#0d6efd">In</span></h5>
            </p>
        </div>
    </div>
</template>

<style scoped>

.brand_card {
    transition: all .4s ease-in-out;
    cursor: pointer;
    /* border: 1px solid transparent; */
}
.brand_card:hover {
    /* border: 1px solid #0d6efd !important; */
}
</style>

<script>
export default {
    props: [],
    components: {  },
    data: () => ({}),
    computed: {},
    mounted() { },
    created() { },
    methods: {
        redirect() {
            return  window.open(process.env.MIX_APP_URL, '_blank');
        }
    }
}
</script>