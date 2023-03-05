<template>
    <DefaultLayout>
        <template v-slot:content>
            <!-- login -->
            <div class="d-flex justify-content-center pt-5 pb-5">
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
                                    value="" placeholder="E-mail" />
                            </div>

                            <div class="text-danger" v-if="errors.password != ''">
                                {{ errors.password[0] || "" }}
                            </div>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fas fa-key"></i>
                                </span>
                                <input type="password" name="password" v-model="formData.password"
                                    class="form-control input_pass" value="" placeholder="Senha" />
                            </div>
                            <div class="d-flex justify-content-center mt-3 login_container">
                                <button type="button" name="button" class="btn login_btn" @click.prevent="auth()">
                                    <span v-if="loading"> Carregando ...</span>
                                    <span v-else>Entrar</span>
                                </button>
                            </div>
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
import { mapActions } from "vuex";
import DefaultLayout from '../../layouts/tenant_site/DefaultLayout.vue';

export default {
    props: [],
    components: {
        DefaultLayout
    },
    data: () => ({
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
    computed: {},
    mounted() { },
    methods: {
        ...mapActions(["login"]),
        auth() { },
        reset() {
            this.errors = { email: "", password: "" };
        },
    }
}
</script>