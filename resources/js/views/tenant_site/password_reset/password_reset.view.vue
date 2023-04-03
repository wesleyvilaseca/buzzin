<template>
    <DefaultLayout>
        <template v-slot:content>

            <div class="pt-4 pb-5">
                <buzzInBrandComponent />
            </div>
            <!-- login -->
            <div class="d-flex justify-content-center pb-5">
                <div class="user_card">
                    <!-- <div class="d-flex justify-content-center">
                        <div class="brand_logo_container">
                            <img src="@/assets/imgs/vue-food.png" class="brand_logo" alt="Logo" />
                        </div>
                    </div> -->
                    <div class="d-flex justify-content-center form_container">
                        <form>
                            <div class="text-danger" v-if="errors.password != ''">
                                {{ errors.password[0] || "" }}
                            </div>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" v-model="formData.password" class="form-control input_pass"
                                    placeholder="Senha" />
                            </div>

                            <div class="text-danger" v-if="errors.confirm_password != ''">
                                {{ errors.confirm_password[0] || "" }}
                            </div>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" v-model="formData.confirm_password" class="form-control input_pass"
                                    placeholder="Confirme a senha" />
                            </div>

                            <div class="d-flex justify-content-center mt-3 login_container">
                                <button type="button" name="button" class="btn login_btn" @click.prevent="recover()">
                                    <span v-if="loading"> Carregando ...</span>
                                    <span v-else>Enviar</span>
                                </button>
                            </div>
                            <input type="hidden" id="recaptcha">
                        </form>
                    </div>
                </div>
            </div>
            <!-- login-->
        </template>
    </DefaultLayout>
</template>

<style scoped>
.login_btn {
    background: v-bind("paleta.btn_color") !important;
    color: white !important;
    border-radius: 50px;
}

.login_btn:hover {
    background: v-bind("paleta.btn_color_hover") !important;
}

.input-group-text {
    background: v-bind("paleta.links") !important;
    color: white !important;
    border-color: v-bind("paleta.links");
    border-radius: 0.25rem 0 0 0.25rem !important;
}

.input-group:focus {
    border-color: v-bind("paleta.links");
    box-shadow: none;
    outline: 0;
}
</style>

<script>
import { mapActions, mapState } from "vuex";
import DefaultLayout from '../../layouts/tenant_site/DefaultLayout.vue';
import buzzInBrandComponent from "../../../components/common/buzzInBrandComponent.vue";
import { toast } from 'vue3-toastify';

export default {
    props: {
        token: String,
        email: String
    },
    components: {
        DefaultLayout,
        buzzInBrandComponent
    },
    data: () => ({
        recaptcha: "",
        loading: false,
        formData: {
            password: "",
            confirm_password: "",
        },
        errors: {
            password: "",
            confirm_password: ""
        },
    }),
    computed: {
        ...mapState({
            company: (state) => state.tenant.company,
            paleta: (state) => state.layout.paleta

        })
    },
    mounted() { },
    created() { },
    methods: {
        ...mapActions(["resetPassword"]),
        recover() {
            this.reset();

            if (this.recaptcha == 'N') {
                return toast.error("Erro na validação do recaptcha", { autoClose: 4000 });
            }

            this.loading = true;
            const params = {
                token: this.token,
                email: this.email,
                ...this.formData,
            };

            this.resetPassword(params)
                .then((res) => {
                    toast.success("Conta recuperada com sucesso.", { autoClose: 5000 });
                    setTimeout(() => window.location.href = `http://${this.company.subdomain}/app/login`, 4000);
                })
                .catch((error) => {
                    const errorResponse = error.response;
                    if (errorResponse.status == 403) {
                        return toast.error("Operação não autorizada", { autoClose: 3000 });
                    }

                    this.errors = Object.assign(this.errors, errorResponse.data.errors);
                    toast.error("Falha na operação", { autoClose: 3000 });
                    setTimeout(() => this.reset(), 4000);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        reset() {
            if (!this.recaptcha) {
                this.recaptcha = document.getElementById('recaptcha').value;
            }
            this.errors = { password: "", confirm_password: "" };
        },
    }
}
</script>