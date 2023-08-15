<template>
    <div class="container pt-5 pb-3">
        <div class="my-4">
            <h4 class="title-tenant">Minha conta</h4>
        </div>
        <div class="my-orders my-4">
            <div class="row">
                <div class="col-md-7">
                    <div class="card p-3">
                        <div class="form-group mt-2">
                            <label>Nome:</label>
                            <input type="text" v-model="form.name" class="form-control form-control-sm">
                            <div class="form-text text-danger" v-if="errors.name != ''">
                                {{ errors.name[0] || "" }}
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label>Email: *</label>
                            <input type="text" v-model="form.email" class="form-control form-control-sm" />
                        </div>

                        <div class="form-group mt-2">
                            <label>Celular: *</label>
                            <input type="text" v-model="form.mobile_phone" class="form-control form-control-sm"
                                v-mask="'(##) #####-####'">
                            <div class="form-text text-danger" v-if="errors.mobile_phone != ''">
                                {{ errors.mobile_phone[0] || "" }}
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label>CPF: *</label>
                            <input type="text" v-model="form.cpf" class="form-control form-control-sm"
                                v-mask="'###.###.###-##'" />
                            <div class="form-text text-danger" v-if="errors.cpf != ''">
                                {{ errors.cpf[0] || "" }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn save_button mt-2" @click.prevent="updateC()"
                                :disabled="loading">
                                <span v-if="loading">Salvando...</span>
                                <span v-else> Salvar</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="card p-3">
                        <div class="form-group mt-2">
                            <label>Nova senha:</label>
                            <input type="password" v-model="formPassword.new_password" class="form-control form-control-sm">
                            <div class="form-text text-danger" v-if="errors.new_password != ''">
                                {{ errors.new_password[0] || "" }}
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label>Confirme a nova senha:</label>
                            <input type="password" v-model="formPassword.new_password_confirm"
                                class="form-control form-control-sm">
                            <div class="form-text text-danger" v-if="errors.new_password_confirm != ''">
                                {{ errors.new_password_confirm[0] || "" }}
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn save_button mt-2" @click.prevent="updatePasswordAccoutn()"
                                :disabled="loading">
                                <span v-if="loading">Salvando...</span>
                                <span v-else> Salvar</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.save_button {
    background: v-bind("paleta.btn_color") !important;
    color: v-bind("paleta.btn_color_letter") !important;
    border-radius: 25px !important;
}

.save_button:hover {
    background: v-bind("paleta.btn_color_hover") !important;
}
</style>

<script>
import { mapActions, mapState } from "vuex";
import { toast } from 'vue3-toastify';

export default {
    props: [],
    components: {},
    data: () => ({
        loading: false,
        canSaveAccount: false,
        form: {
            name: "",
            email: "",
            mobile_phone: "",
            cpf: "",
        },
        formPassword: {
            new_password: "",
            new_password_confirm: ""
        },
        errors: {
            name: "",
            mobile_phone: "",
            cpf: "",
            new_password: "",
            new_password_confirm: ""
        }
    }),
    computed: {
        ...mapState({
            paleta: (state) => state.layout.paleta,
            me: (state) => state.auth.me,
        })
    },
    created() { },
    mounted() {
    },
    methods: {
        ...mapActions([
            "updateAccount",
            "updatePassword"
        ]),
        updateC() {
            this.reset();
            this.validateForm();
            if (!this.canSaveAccount) return;
            this.loading = true;
            const params = {
                name: this.form.name,
                email: this.form.email,
                mobile_phone: this.encode(this.form.mobile_phone),
                cpf: this.encode(this.form.cpf)
            }

            this.updateAccount(params)
                .then(() => {
                    toast.success("Conta atualizado com sucesso", { autoClose: 3000 });
                })
                .catch((error) => {
                    const errorResponse = error.response;
                    this.errors = Object.assign(this.errors, errorResponse.data.errors);
                    toast.error(
                        "Falha na operação",
                        { autoClose: 5000 }
                    );
                })
                .finally(() => {
                    this.loading = false;
                })
        },

        updatePasswordAccoutn() {
            this.reset();
            this.validateForm();
            if (!this.canSaveAccount) return;
            this.loading = true;

            this.updatePassword(this.formPassword)
                .then(() => {
                    toast.success("Senha atualizado com sucesso", { autoClose: 3000 });
                })
                .catch((error) => {
                    const errorResponse = error.response;
                    this.errors = Object.assign(this.errors, errorResponse.data.errors);
                    toast.error(
                        "Falha na operação",
                        { autoClose: 5000 }
                    );
                })
                .finally(() => {
                    this.loading = false;
                })

        },

        validadeFormPassword() {
            if (this.form.new_password.length < 8) {
                this.canSaveAccount = false;
                return this.errors.new_password = ["A senha precisa ter no mínimo 8 caracteres"];
            }

            if (this.form.new_password !== this.form.new_password_confirm) {
                this.canSaveAccount = false;
                this.errors.new_password = ["A senha e confirmação da senha precisam ser iguais"];
                this.errors.new_password_confirm = ["A senha e confirmação da senha precisam ser iguais"];
            }

            this.canSaveAccount = true;
        },

        validateForm() {
            if (this.form.mobile_phone !== this.decode(this.me.mobile_phone)) {
                if (this.form.mobile_phone.length < 15) {
                    this.canSaveAccount = false;
                    return this.errors.mobile_phone = ["Informe um tefone celular válido"];
                }
            }

            if (this.form.name !== this.me.name) {
                if (this.form.name.length < 3) {
                    this.canSaveAccount = false;
                    return this.errors.name = ["Informe um nome válido"];
                }
            }

            this.canSaveAccount = true;
        },

        b64: function (str) {
            return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
                function toSolidBytes(match, p1) {
                    return String.fromCharCode('0x' + p1);
                }));
        },
        b64D: function (str) {
            return decodeURIComponent(atob(str).split('').map(function (c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
        },
        reverse(s) {
            return s.split("").reverse().join("");
        },

        decode(value) {
            value = this.reverse(value);
            const aces = 10;
            var count = 0;
            while (true) {
                if (count === aces) break;
                value = this.b64D(value);
                count++;
            }
            return value;
        },

        encode(value) {
            const aces = 10;
            var count = 0;
            while (true) {
                if (count === aces) break;
                value = this.b64(value);
                count++;
            }
            return this.reverse(value);
        },
        reset() {
            this.errors = { name: "", mobile_phone: "", cpf: "", new_password: "", new_password_confirm: "" }
        },
    },
    watch: {
        me() {
            this.form.name = this.me.name;
            this.form.email = this.me.email;
            this.form.mobile_phone = this.decode(this.me.mobile_phone);
            this.form.cpf = this.decode(this.me.doc);
        }
    },

}
</script>