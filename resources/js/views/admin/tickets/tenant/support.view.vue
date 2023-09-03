<template>
    <div class="card">
        <div class="card-header">
            Lista de chamados <button class="ms-2 btn btn-outline-secondary btn-sm" @click.prevent="showModal(true)">
                Abrir
                novo
                chamado
            </button>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
                        role="tab" aria-controls="home" aria-selected="true">Pendentes</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">Finalizados</button>
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
                                <tr v-if="ticket.status == 0 || ticket.status == 1">
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
                            <template v-for="(ticket, index) in my_tickets.data" :key="index" v-if="my_tickets.data.length > 0">
                                <tr v-if="ticket.status == 2">
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

    <div id="exampleModalLive" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
        :style="{ display: modal }">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel">Novo chamado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="showModal(false)"></button>
                </div>
                <form action="#" method="POST">
                    <div class="modal-body">
                        <div class="container mb-2">
                            <div class="form-group mt-2">
                                <label>* Qual o tipo de chamado?</label>
                                <select v-model="form.ticket_type_id" class="form-control form-control-sm" required>
                                    <option disabled selected>Selecione uma opção</option>
                                    <option value="0">
                                        Dúvidas
                                    </option>
                                    <option value="1">
                                        Suporte
                                    </option>
                                </select>
                                <div class="form-text text-danger" v-if="errors.ticket_type_id != ''">
                                    {{ errors.ticket_type_id[0] || "" }}
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <label>* Descrição do chamado:</label>
                                <input type="text" v-model="form.description" class="form-control form-control-sm" required>
                                <div class="form-text text-danger" v-if="errors.description != ''">
                                    {{ errors.description[0] || "" }}
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <label>* Detalhes:</label>
                                <textarea id="message" ols="30" rows="5" class="form-control form-control-sm editor">
                                </textarea>
                                <div class="form-text text-danger" v-if="errors.message != ''">
                                    {{ errors.message[0] || "" }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"
                            @click="showModal(false)">Cancelar</button>
                        <button class="btn btn-sm btn-primary" @click.prevent="newSuport()">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modalConversation" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel"
        :style="{ display: modalConvesation }">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLiveLabel">Detalhes do chamado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        @click="showModalConversation(false)"></button>
                </div>
                <div class="modal-body">
                    <template v-if="conversationId">
                        <conversationView :id="conversationId" />
                    </template>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"
                        @click="showModalConversation(false)">Fechar</button>
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
        canStoreTicket: false,
        loding: false,
        modal: 'none',
        modalConvesation: 'none',
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
    computed: {
        ...mapState({
            my_tickets: (state) => state.ticket.my_tickets
        }),
    },
    mounted() {
        this.getAll();
        this.getTicketsByTenant();
    },
    methods: {
        ...mapActions(["getTicketsByTenant"]),
        showModal(state) {
            if (!state) {
                this.modal = 'none';
                this.resetForm();
                return;
            }
            this.modal = 'block';
        },
        showModalConversation(state, id = null) {
            window.location.href = `/admin-tenant-tickets/${id}/ticket`;
        },
        newSuport() {
            this.validateForm();
            if (!this.canStoreTicket) return;

            this.loading = true
            axios.post('/api/v1/new-ticket', this.form)
                .then(response => {
                    this.showModal(false);
                    this.resetForm();
                    this.getAll();
                })
                .catch(error => alert('error'))
                .finally(() => this.loading = false)
        },
        validateForm() {
            this.reset();
            if (!this.form.ticket_type_id) {
                this.canStoreTicket = false;
                return this.errors.ticket_type_id = ["Selecione o tipo de chamado"];
            }
            if (!this.form.description) {
                this.canStoreTicket = false;
                return this.errors.description = ["Informe uma descrição para o chamado"];
            }

            this.form.message = tinymce.get("message").getContent({ format: 'raw' });
            if (!this.form.message) {
                this.canStoreTicket = false;
                return this.errors.message = ["Descreva o seu chamado"];
            }

            this.canStoreTicket = true;
        },
        getAll() {
            axios.get('/api/v1/my-tickets')
                .then(response => this.tickets = response.data)
                .catch(error => alert('error'))
        },
        reset() {
            this.canStoreTicket = false;
            this.errors = { ticket_type_id: "", description: "", message: "" }
        },
        resetForm() {
            this.form = { ticket_type_id: "", description: "", message: "" }
        }
    }
}
</script>