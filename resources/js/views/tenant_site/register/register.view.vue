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
                                ]" placeholder="Nome" />
                            </div>


                            <div class="text-danger" v-if="errors.mobile_phone != ''">
                                {{ errors.mobile_phone[0] || "" }}
                            </div>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <i class="fa-solid fa-mobile"></i>
                                </span>
                                <input type="text" v-model="formData.mobile_phone" :class="[
                                    'form-control',
                                    'input_user',
                                    { 'is-invalide': errors.mobile_phone != '' },
                                ]" v-mask="'(##) #####-####'" placeholder="(91) 98820-3132" />
                            </div>

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
                                <input type="password" v-model="formData.password" name="password"
                                    class="form-control input_pass" placeholder="Senha" minlength="8" />
                            </div>
                            <div class="d-flex justify-content-center login_container">
                                <button type="button" name="button" class="btn login_btn" :disabled="loading"
                                    @click.prevent="registerClient()">
                                    <span v-if="loading"> Carregando ...</span>
                                    <span v-else>Cadastrar</span>
                                </button>
                            </div>
                            <input type="hidden" id="recaptcha">
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
import DefaultLayout from '../../layouts/tenant_site/DefaultLayout.vue';
import { mapActions, mapState } from "vuex";
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
        canRegister: false,
        loading: false,
        formData: {
            name: "",
            email: "",
            password: "",
            mobile_phone: ""
        },
        errors: {
            name: "",
            email: "",
            password: "",
            mobile_phone: ""
        },
    }),
    computed: {
        ...mapState({
            company: (state) => state.tenant.company,
            paleta: (state) => state.layout.paleta
        }),
    },
    mounted() { },
    methods: {
        ...mapActions(["register"]),
        registerClient() {
            this.reset();
            this.validateForm();
            if (!this.canRegister) return;

            if(this.recaptcha == 'N') {
                return toast.error("Erro na validação do recaptcha", { autoClose: 4000 });
            }

            this.loading = true;
            this.register(this.formData)
                .then((res) => {
                    toast.success("Cadastro realizado com sucesso", { autoClose: 3000 });
                    window.location.href = `http://${this.company.domain}/app/login`;
                })
                .catch((error) => {
                    const errorResponse = error.response;
                    if (errorResponse.status === 422) {
                        this.errors = Object.assign(this.errors, errorResponse.data.errors);
                        toast.error(
                            "Dados inválidos, verifique novamente",
                            { autoClose: 5000 }
                        );
                        return;
                    }

                    toast.error(
                        "Falha na operação",
                        { autoClose: 5000 }
                    );

                    setTimeout(() => this.reset(), 4000);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        validateForm() {
            if (!this.formData.name) {
                this.canRegister = false;
                return this.errors.name = ["O nome é um campo obrigatório"];
            }

            if (this.formData.name.length < 3) {
                this.canRegister = false;
                return this.errors.name = ["Insira um nome válido"];
            }

            var name = this.formData.name;
            name = name.split(" ");

            if(name.length < 2) {
                this.canRegister = false;
                return this.errors.name = ["Informe nome e sobronome válido"];
            }

            if(name[0].length < 3 || name[1].length < 3) {
                this.canRegister = false;
                return this.errors.name = ["Informe nome e sobronome válido"];
            }

            if (!this.formData.mobile_phone) {
                this.canRegister = false;
                return this.errors.mobile_phone = ["O número de telefone é um campo obrigatório"];
            }

            if (this.formData.mobile_phone.length < 15) {
                this.canRegister = false;
                return this.errors.mobile_phone = ["O número de telefone está incompleto"];
            }

            if (!this.formData.email) {
                this.canRegister = false;
                return this.errors.email = ["O email é um campo obrigatório"];
            }
            if (!this.formData.password) {
                this.canRegister = false;
                return this.errors.password = ["A senha é um campo obrigatório"];
            }

            if (this.formData.password.length < 8) {
                this.canRegister = false;
                return this.errors.password = ["A senha deve ter pelo menos 8 caracteres"];
            }


            this.canRegister = true;
        },
        reset() {
            if(!this.recaptcha){
                this.recaptcha = document.getElementById('recaptcha').value;
            }
            this.errors = { name: "", email: "", password: "",   mobile_phone: "" };
        },
    }
}
</script>