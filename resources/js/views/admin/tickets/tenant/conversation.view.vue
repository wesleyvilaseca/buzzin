<template>
    <div class="top-chat">
        <div class="desc"></div>
        <div class="buttons" v-if="canSendMessage">
            <button class="btn btn-sm btn-primary" @click.prevent="closeTicket()">Encerrar ticket</button>
        </div>

        <div class="buttons" v-if="!canSendMessage">
            <div class="alert alert-warning p-1 mt-3 fade show" role="alert">
                Esse Ticket foi encerrado
            </div>
        </div>
    </div>
    <section class="chatbox">
        <section class="chat-window pt-2" id="chat_">
            <template v-for="(msg, index) in conversation.data" :key="index">
                <article class="msg-container msg-self" id="msg-0" v-if="msg?.created_by_tenant">
                    <div class="msg-box">
                        <div class="flr">
                            <div class="messages">
                                <p class="msg" id="msg-1" v-html="msg.message"></p>
                            </div>
                            <span class="timestamp">
                                <span class="username">{{ msg.user_name }}</span>&bull;<span class="posttime">
                                    {{ msg.created_at }}</span>
                            </span>
                        </div>
                        <img class="user-img" id="user-0"
                            src="//gravatar.com/avatar/56234674574535734573000000000001?d=retro" />
                    </div>
                </article>
                <article class="msg-container msg-remote" id="msg-0" v-else>
                    <div class="msg-box">
                        <img class="user-img" id="user-0"
                            src="//gravatar.com/avatar/00034587632094500000000000000000?d=retro" />
                        <div class="flr">
                            <div class="messages">
                                <p class="msg" id="msg-0" v-html="msg.message"></p>
                            </div>
                            <span class="timestamp"><span class="username">{{ msg.user_name }}</span>&bull;<span
                                    class="posttime">{{ msg.created_at }}</span></span>
                        </div>
                    </div>
                </article>
            </template>
        </section>
        <form class="chat-input" onsubmit="return false;">
            <textarea cols="30" rows="10" placeholder="Escreva uma mensagem" v-model="form.message"></textarea>
            <button @click="this.sendMessage()" v-if="canSendMessage">
                <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                    <path fill="rgba(0,0,0,.38)"
                        d="M17,12L12,17V14H8V10H12V7L17,12M21,16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V7.5C3,7.12 3.21,6.79 3.53,6.62L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.79,6.79 21,7.12 21,7.5V16.5M12,4.15L5,8.09V15.91L12,19.85L19,15.91V8.09L12,4.15Z" />
                </svg>
            </button>
        </form>
    </section>
</template>

<script>

import { mapState, mapActions, mapMutations } from "vuex";

export default {
    props: {
        ticketid: Number
    },
    components: {},
    data: () => ({
        user_id: '',
        ticket_status: '',
        form: {
            ticket_id: "",
            message: "",
            attendance_user_id: ""
        },
        errors: {
            ticket_id: "",
            message: "",
            attendance_user_id: ""
        }
    }),
    computed: {
        ...mapState({
            conversation: (state) => state.ticket.ticket
        }),

        canSendMessage() {
            this.checkStatus();
            if(this.ticket_status == 3 || this.ticket_status == 4) {
                return false;
            }
            
            return true;
        }
    },
    mounted() {
        this.getTicket(this.ticketid);
        this.form.ticket_id = this.ticketid;

        this.user_id = window?.Laravel?.user_id;
        const that = this;
        window.Echo.channel(`buzzin_database_private-message-ticket-support-created.${that.user_id}`)
            .listen('MessageTicketSupportCreated', (e) => {
                that.setNewMessage(e.message);
                that.checkStatus();
                setTimeout(that.scroll(), 2000);
            })
        that.scroll();
    },
    methods: {
        ...mapActions(["getTicket", "sendSupportTenatMessage", "closeTicketByTenant"]),
        ...mapMutations({ setNewMessage: "SET_NEW_MESSAGE_TICKET" }),

        sendMessage() {
            if (!this.canSendMessage) {
                return;
            }

            if (!this.form.message) {
                return;
            }

            if (!this.form.attendance_user_id) {
                this.form.attendance_user_id = this.getAttendantId()
            }

            this.sendSupportTenatMessage(this.form)
                .then(() => {
                    this.form.message = "";
                    this.scroll()
                })
        },

        closeTicket() {
            if (!this.form.tenant_user_id) {
                this.form.tenant_user_id = this.getAttendantId()
            }

            this.closeTicketByTenant(this.form)
                .then(() => {
                    return window.location.href = `/admin-tenant-tickets`;
                })
        },

        scroll() {
            $("#chat_").animate({ scrollTop: 20000000 }, "slow");
        },

        getAttendantId() {
            const objetoEncontrado = this.conversation.data.find(objeto => objeto.user_id != this.user_id);
            return objetoEncontrado.user_id;
        },

        checkStatus() {
            const objetoEncontrado = this.conversation.data.find(objeto => objeto.status == 3 || objeto.status == 4);
            if(objetoEncontrado) {
                this.ticket_status = objetoEncontrado.status;
            }
        }
    }
}
</script>