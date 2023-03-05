<template>
    <DefaultLayout>
        <template v-slot:content>
            <!-- login -->
            <div class="d-flex justify-content-center pt-5 pb-5">
                <div class="user_card">
                    <!-- <div class="d-flex justify-content-center">
                        <div class="brand_logo_container">
                            <img src="imgs/vue-food.png" class="brand_logo" alt="Logo" />
                        </div>
                    </div> -->
                    <div class="d-flex justify-content-center form_container">
                        <form>
                            <div class="text-danger" v-if="errors.name != ''">
                                {{ errors.name[0] || "" }}
                            </div>

                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text" v-model="formData.name" name="name" :class="[
                                    'form-control',
                                    'input_user',
                                    { 'is-invalide': errors.name != '' },
                                ]" value="" placeholder="Nome" />
                            </div>

                            <div class="text-danger" v-if="errors.email != ''">
                                {{ errors.email[0] || "" }}
                            </div>

                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" v-model="formData.email" name="email" class="form-control input_user"
                                    value="" placeholder="E-mail" />
                            </div>

                            <div class="text-danger" v-if="errors.password != ''">
                                {{ errors.password[0] || "" }}
                            </div>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" v-model="formData.password" name="password"
                                    class="form-control input_pass" value="" placeholder="Senha" />
                            </div>
                            <div class="d-flex justify-content-center login_container">
                                <button type="button" name="button" class="btn login_btn" :disabled="loading"
                                    @click.prevent="registerClient()">
                                    <span v-if="loading"> Carregando ...</span>
                                    <span v-else>Cadastrar</span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-center links">
                            Já tem conta?
                            <a href="/app/login" class="ml-2">
                                Login
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
    background: #4040ff !important;
    color: white !important;
    border-radius: 50px;
}

.login_btn:hover {
    background: #4060ff !important;
}

.input-group-text {
    background: #4040ff !important;
    color: white !important;
    border-color: #4040ff;
    border-radius: 0.25rem 0 0 0.25rem !important;
}

.input-group:focus {
    border-color: #4040ff;
    box-shadow: none;
    outline: 0;
}
</style>

<script>
import DefaultLayout from '../../layouts/tenant_site/DefaultLayout.vue';
import { mapActions } from "vuex";

export default {
    props: [],
    components: {
        DefaultLayout
    },
    data: () => ({
        loading: false,
        formData: {
            name: "",
            email: "",
            password: "",
        },
        errors: {
            name: "",
            email: "",
            password: "",
        },
    }),
    computed: {},
    mounted() { },
    methods: {
        ...mapActions(["register"]),
        registerClient() {
            this.reset();
            this.loading = true;
            this.register(this.formData)
                .then((res) => {
                    this.$vToastify.error("Cadastro realizado com sucesso", "Success");
                    this.$router.push({ name: "login" });
                    console.log(res);
                })
                .catch((error) => {
                    const errorResponse = error.response;
                    if (errorResponse.status === 422) {
                        this.errors = Object.assign(this.errors, errorResponse.data.errors);
                        this.$vToastify.error(
                            "Dados inválidos, verifique novamente",
                            "Erro"
                        );
                        return;
                    }
                    this.$vToastify.error("Falha na operação", "Erro");
                    setTimeout(() => this.reset(), 4000);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        reset() {
            this.errors = { name: "", email: "", password: "" };
        },
    }
}
</script>