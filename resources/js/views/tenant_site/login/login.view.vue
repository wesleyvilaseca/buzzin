<template>
    <DefaultLayout>
        <template v-slot:content>
            <div class="pt-4 pb-5">
                <buzzInBrandComponent />
            </div>

            <div class="d-flex justify-content-center pb-5">
                <div class="user_card">
                    <!-- <div class="d-flex justify-content-center">
                        <div class="brand_logo_container">
                            <img src="@/assets/imgs/vue-food.png" class="brand_logo" alt="Logo" />
                        </div>
                    </div> -->
                    <div class="d-flex justify-content-center form_container">
                        <form>
                            <div class="text-danger" v-if="errors.email != ''">
                                {{ errors.email[0] || "" }}
                            </div>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" v-model="formData.email" name="email" class="form-control input_user"
                                    placeholder="E-mail" />
                            </div>

                            <div class="text-danger" v-if="errors.password != ''">
                                {{ errors.password[0] || "" }}
                            </div>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" name="password" v-model="formData.password"
                                    class="form-control input_pass" placeholder="Senha" minlength="8" />
                            </div>
                            <div class="d-flex justify-content-center mt-3 login_container">
                                <button type="button" name="button" class="btn login_btn" @click.prevent="auth()">
                                    <span v-if="loading"> Carregando ...</span>
                                    <span v-else>Entrar</span>
                                </button>
                            </div>
                            <input type="hidden" id="recaptcha">
                        </form>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-center links">
                            Não tem uma conta?
                            <a href="/app/register" class="ml-2">
                                Cadastre-se!
                            </a>
                        </div>
                    </div>

                     <div class="mt-4">
                        <div class="d-flex justify-content-center links">
                            Esqueceu a senha?
                            <a href="/app/recuperar-acesso" class="ml-2">
                                Recuperar a conta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- login-->
        </template>
    </DefaultLayout>
</template>

<style scoped>
.login_btn {
    background: v-bind("paleta.btn_color")  !important;
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
import { toast } from 'vue3-toastify';
import buzzInBrandComponent from "../../../components/common/buzzInBrandComponent.vue";


export default {
    props: [],
    components: {
        DefaultLayout,
        buzzInBrandComponent
    },
    data: () => ({
        recaptcha: "",
        loading: false,
        formData: {
            email: "",
            password: "",
        },
        errors: {
            email: "",
            password: "",
        },
    }),
    computed: {
        ...mapState({
            company: (state) => state.tenant.company,
            paleta: (state) => state.layout.paleta

        }),
        deviceName() {
            return (
                navigator.appCodeName +
                navigator.appName +
                navigator.platform +
                this.formData.email
            );
        },
    },
    mounted() { },
    created() {},
    methods: {
        ...mapActions(["login"]),
        auth() {
            this.reset();

            if(this.recaptcha == 'N') {
                return toast.error("Erro na validação do recaptcha", { autoClose: 4000 });
            }

            this.loading = true;
            const params = {
                device_name: this.deviceName,
                ...this.formData,
            };
            this.login(params)
                .then((res) => {
                    toast.success("Login realizado com sucesso", { autoClose: 3000 });
                    window.location.href = `http://${this.company.subdomain}`;
                })
                .catch((error) => {
                    const errorResponse = error.response;
                    if (errorResponse.status === 422 || errorResponse.status === 404) {
                        this.errors = Object.assign(this.errors, errorResponse.data.errors);
                        toast.error("Dados inválidos, verifique novamente", { autoClose: 4000 });
                        return;
                    }
                    toast.error("Falha na operação", { autoClose: 3000 });
                    setTimeout(() => this.reset(), 4000);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        reset() {
            if(!this.recaptcha){
                this.recaptcha = document.getElementById('recaptcha').value;
            }
            this.errors = { email: "", password: "" };
        },
    }
}
</script>