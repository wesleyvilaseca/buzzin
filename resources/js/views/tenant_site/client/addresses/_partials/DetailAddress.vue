<template>
    <div id="exampleModalLive" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
        :style="{ display: display }">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel">Endereço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="closeDetailsAddress"></button>
                </div>
                <div class="modal-body">
                    <slot name="content">
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    props: {
        display: {
            required: true
        }
    },
    computed: {},
    data() {
        return {
            status: '',
            loading: false
        }
    },
    methods: {
        closeDetailsAddress() {
            this.$emit('closeDetailsAddress')
        },
    },
    watch: {},
}
</script>