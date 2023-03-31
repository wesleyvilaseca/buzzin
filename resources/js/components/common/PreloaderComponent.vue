<template>
    <div class="preloader" v-if="preloader">
        <img src="../../assets/imgs/preloader.gif" alt="Carregando..." style="max-width: 80px;" />
        <p class="fw-bold">{{ textPreloader }}</p>
    </div>
</template>
  
<script>
import { mapState } from "vuex";
export default {
    computed: {
        ...mapState({
            preloader: (state) => state.preloader.preloader,
            textPreloader: (state) => state.preloader.textPreloader
        }),
    },
};
</script>