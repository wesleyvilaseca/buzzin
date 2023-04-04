<template>
    <span v-if="hasExtension">
        <a :href="extension?.data?.link"
            class="float" target="_blank">
            <i class="fa-brands fa-whatsapp my-float"></i>
        </a>
    </span>
</template>

<style scoped>
.float {
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 40px;
    right: 40px;
    background-color: #25d366;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 30px;
    box-shadow: 2px 2px 3px #999;
    z-index: 100;
}

.my-float {
    margin-top: 16px;
}
</style>

<script>
import { mapState, mapActions } from "vuex";

export default {
    props: [],
    components: {},
    computed: {
        ...mapState({
            extensions: (state) => state.tenant.extensions,
            company: (state) => state.tenant.company,
        }),

        // hasExtension() {
        //     return this.extensions.some((item) => {
        //         return item.tag == this.tag;
        //     });
        // }
    },
    data: () => ({
        tag: 'whatsapp',
        hasExtension: false,
        extension: {}
    }),

    mounted() { },
    created() { },
    methods: {
        checkHasExtension() {
            this.hasExtension = this.extensions.data.some((item) => {
                return item.tag == this.tag;
            });

            if(this.hasExtension){
                this.extension = this.extensions.data.find(({ tag }) => tag === this.tag);
                this.extension.data = JSON.parse(this.extension?.data);
            }
        },

        setExtension() {
            
        }
    },
    watch: {
        'extensions.data': function (newVal, oldVal) {
            if(newVal.length > 0) this.checkHasExtension()
        },
    }
}
</script>