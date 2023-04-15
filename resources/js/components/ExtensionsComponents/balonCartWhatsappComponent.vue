<template>
    <span v-if="hasExtension">
        <a :href="link" class="whatsappCart" target="_blank">
            <i class="fa-brands fa-whatsapp my-float"></i>
            {{ randomMessages }}
        </a>
    </span>
</template>

<style scoped>
.whatsappCart {
    width: 100%;
    text-decoration: none;
    padding: 5px 10px;
    background-color: #25d366;
    color: #FFF;
    border-radius: 50px;
    text-align: center;
    font-size: 14px;
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
    props: ['item'],
    components: {},
    computed: {
        ...mapState({
            extensions: (state) => state.tenant.extensions,
            company: (state) => state.tenant.company,
        }),

        link() {
            const number = this.extension?.data?.number.replace(/\D/g, '');
            return `https://api.whatsapp.com/send?phone=55${number}&text=${this.randomMessages} - produto ${this.item.description} R$ ${this.item.price}`;
        },

        randomMessages() {
            return this.messages[Math.floor(Math.random()*this.messages.length)];
        }
    },
    data: () => ({
        tag: 'whatsapp',
        hasExtension: false,
        extension: {},
        messages: [
            'Duvidas?',
            'Tenho interesse!',
            'Gostei desse',
            'Quero saber mais',
        ]
    }),

    mounted() { },
    created() { },
    methods: {
        checkHasExtension() {
            this.hasExtension = this.extensions.data.some((item) => {
                return item.tag == this.tag;
            });

            if (this.hasExtension) {
                this.extension = this.extensions.data.find(({ tag }) => tag === this.tag);
                // this.extension.data = JSON.parse(this.extension?.data);
            }
        },

        setExtension() {

        }
    },
    watch: {
        'extensions.data': function (newVal, oldVal) {
            if (newVal.length > 0) this.checkHasExtension()
        },
    }
}
</script>