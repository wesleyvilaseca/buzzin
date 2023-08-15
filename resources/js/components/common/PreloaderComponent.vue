<template>
    <div class="preloader" v-if="preloader">
        <img src="../../assets/imgs/preloader.gif" alt="Carregando..." style="max-width: 80px;" />
        <p class="fw-bold">{{ textPreloader }}</p>
    </div>
</template>
  
<script>
import { mapState, mapMutations } from "vuex";
export default {
    data: () => ({
        counter: 0
    }),
    computed: {
        ...mapState({
            preloader: (state) => state.preloader.preloader,
            textPreloader: (state) => state.preloader.textPreloader
        }),
    },
    methods: {
        ...mapMutations({
            setPreloader: "SET_PRELOADER",
            setTextPreloader: "SET_TEXT_PRELOADER"
        }),
    },
    mounted() {
        window.axios.interceptors.request.use((config) => {
            this.counter++;
            this.setPreloader(true);
            return config
        }, function (error) {

            this.setPreloader(false);
            return Promise.reject(error)
        })

        window.axios.interceptors.response.use((response) => {
            this.counter--;
            if (this.counter == 0) {
                this.setPreloader(false);
            }
            return response
        }, function (error) {
            this.setPreloader(false);
            return Promise.reject(error)
        })
    },

};
</script>