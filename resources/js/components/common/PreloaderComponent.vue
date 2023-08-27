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
        counter: 0,
        loading:false
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

        stop() {
            console.log('aqiu')
        }
    },
    mounted() {
        const that = this;
        window.axios.interceptors.request.use((config) => {
            that.counter++;
            that.setPreloader(true)
            return config
        }, function (error) {
            that.setPreloader(false)
            return Promise.reject(error)
        })

        window.axios.interceptors.response.use((response) => {
            that.counter--;
            if (that.counter == 0) {
                that.setPreloader(false)
            }
            return response
        }, function (error) {
           that.setPreloader(false)
            return Promise.reject(error)
        })
    },

};
</script>