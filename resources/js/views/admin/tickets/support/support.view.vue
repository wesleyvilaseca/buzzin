<template>
    <div class="card">
        <div class="card-header">
            Lista de chamados
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                        role="tab" aria-controls="home" aria-selected="true">Tickets em aberto</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link position-relative" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">
                        Tickets em atendimento
                        <span
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger mt-0 ms-0"
                            v-if="my_tickets.data?.length > 0">
                            {{ my_tickets.data?.length }}
                        </span>
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Status</th>
                                <th>Data da criação</th>
                                <th width="270">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(ticket, index) in tickets" :key="index" v-if="tickets.length > 0">
                                <tr v-if="ticket.status == 0">
                                    <td>{{ ticket.description }}</td>
                                    <td>
                                        <template v-if="ticket.status == 0">
                                            <span class="alert alert-warning p-1"> Em aberto</span>
                                        </template>
                                        <template v-if="ticket.status == 1">
                                            <span class="alert alert-info p-1"> Em atendimento</span>
                                        </template>
                                    </td>
                                    <td>{{ ticket.created_at }}</td>
                                    <td>
                                        <a href="#" @click.prevent="showModalConversation(true, ticket.id)"
                                            class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Status</th>
                                <th>Data da criação</th>
                                <th width="270">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-for="(ticket, index) in my_tickets.data" :key="index"
                                v-if="my_tickets.data?.length > 0">
                                <tr v-if="ticket.status == 1">
                                    <td>{{ ticket.description }}</td>
                                    <td>
                                        <template v-if="ticket.status == 0">
                                            <span class="alert alert-warning p-1"> Em aberto</span>
                                        </template>
                                        <template v-if="ticket.status == 1">
                                            <span class="alert alert-info p-1"> Em atendimento</span>
                                        </template>
                                    </td>
                                    <td>{{ ticket.created_at }}</td>
                                    <td>
                                        <a href="#" @click.prevent="showModalConversation(true, ticket.id)"
                                            class="btn btn-info btn-sm"><i class="fa-solid fa-eye"></i></a>
                                    </td>
                                </tr>
                            </template>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import conversationView from './conversation.view.vue';
import { mapState, mapActions, mapMutations } from "vuex";

export default {
    props: [],
    components: {
        conversationView
    },
    data: () => ({
        conversationId: "",
        loding: false,
        tickets: [],
    }),
    computed: {
        ...mapState({
            my_tickets: (state) => state.ticket.my_tickets
        }),
    },
    mounted() {
        this.getAll();
        this.getTicketsByAttendant().then(() => {
            console.log(this.my_tickets)
        })

    },
    methods: {
        ...mapActions(["getTicketsByAttendant"]),
        getAll() {
            axios.get('/api/v1/tickets')
                .then(response => this.tickets = response.data)
                .catch((error) =>{
                    console.log(error)
                })
        },
        showModalConversation(state, id = null) {
            window.location.href = `/admin-tickets/${id}/ticket`;
        },
    }
}
</script>