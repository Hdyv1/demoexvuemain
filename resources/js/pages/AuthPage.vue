<template>
    <div class="container my-5">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="authForm">
                    <div class="container">
                        <div class="row">
                            <div v-if="authPage">
                                <div class="col-12 mb-3">
                                    <label for="username" class="form-label"
                                        >Имя Пользователя</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Имя пользователя"
                                        name="username"
                                        value="{{ old('username') }}"
                                        v-model="username"
                                    />
                                    <div class="alert alert-danger" v-if="errors.username">
                                        {{ errors.username.join('. ') }}
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="password" class="form-label"
                                        >Пароль</label
                                    >
                                    <input
                                        type="password"
                                        class="form-control"
                                        placeholder="Пароль"
                                        name="password"
                                        v-model="password"
                                    />
                                    <div class="alert alert-danger" v-if="errors.password">
                                        {{ errors.password.join('. ') }}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        @click="login()"
                                    >
                                        Авторизоваться
                                    </button>
                                </div>
                                <div class="col-12">
                                    Ещё нет аккаунта?
                                    <a
                                        @click.prevent="
                                            changeAuth('RegisterPage')
                                        "
                                        href=""
                                        >Зарегистрироваться</a
                                    >
                                </div>
                            </div>
                            <RegisterComponent v-else :changeAuth="changeAuth" :successUser="successUser" :server="server"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import RegisterComponent from '@/components/RegisterComponent.vue';


export default {
    name: "AuthPage",
    data() {
        return {
            username: null,
            password: null,
            authPage: localStorage.getItem("authPage")?(localStorage.getItem("authPage")=='auth'?true:false):true,
            errors: {},
        };
    },
    components: {
        RegisterComponent,
    },
    props: ['server', 'successUser', 'getUser', 'changePage'],
    methods: {
        changeAuth(page) {
            this.authPage = page == "auth" ? true : false;
            localStorage.setItem("authPage", page);
        },
        login(){
            let formdata = new FormData();
            if (this.username) formdata.append('username', this.username);
            if (this.password) formdata.append('password', this.password);

            this.server('login', 'POST', formdata)
                .then((result) => {
                    if (result.errors) {
                        this.errors = result.errors;
                    }
                    if (result.token) {
                        this.successUser(result.token);
                        localStorage.removeItem('authPage');
                    }
                });
        }
    },
};
</script>
