<template>
    <div class="col-12 mb-3">
        <label for="fullname" class="form-label">Полное имя</label>
        <input
            type="text"
            class="form-control"
            placeholder="ФИО"
            name="fullname"
            v-model="fullname"
            value="{{ old('fullname') }}"
        />
        <div class="alert alert-danger" v-if="errors.fullname">
            {{ errors.fullname.join('. ') }}
        </div>
    </div>
    <div class="col-12 mb-3">
        <label for="username" class="form-label">Имя Пользователя</label>
        <input
            type="text"
            class="form-control"
            placeholder="Имя пользователя"
            name="username"
            v-model="username"
            value="{{ old('username') }}"
        />
        <div class="alert alert-danger" v-if="errors.username">
            {{ errors.username.join('. ') }}
        </div>
    </div>
    <div class="col-12 mb-3">
        <label for="email" class="form-label">Email</label>
        <input
            type="text"
            class="form-control"
            placeholder="Email"
            name="email"
            value="{{ old('email') }}"
            v-model="email"
        />
        <div class="alert alert-danger" v-if="errors.email">
            {{ errors.email.join('. ') }}
        </div>
    </div>
    <div class="col-12 mb-3">
        <label for="phonenumber" class="form-label">Номер телефона</label>
        <input
            type="text"
            class="form-control"
            placeholder="791234567890"
            name="phonenumber"
            value="{{ old('phonenumber') }}"
            v-model="phonenumber"
        />
        <div class="alert alert-danger" v-if="errors.phonenumber">
            {{ errors.phonenumber.join('. ') }}
        </div>
    </div>
    <div class="col-12 mb-3">
        <label for="password" class="form-label">Пароль</label>
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
        <button @click="register()" type="submit" class="btn btn-primary">
            Зарегистрироваться
        </button>
    </div>
    <div class="col-12">
        Уже есть аккаунт?
        <a @click.prevent="changeAuth('auth')" href="">Авторизоваться</a>
    </div>
</template>
<script>
export default {
    name: "RegisterComponent",
    data() {
        return {
            fullname: null,
            username: null,
            password: null,
            email: null,
            phonenumber: null,
            errors: {},
        };
    },
    props: ['changeAuth', 'server', 'successUser'],
    methods: {
        register(){
            let formdata = new FormData();
            if (this.fullname) formdata.append('fullname', this.fullname);
            if (this.username) formdata.append('username', this.username);
            if (this.password) formdata.append('password', this.password);
            if (this.email) formdata.append('email', this.email);
            if (this.phonenumber) formdata.append('phonenumber', this.phonenumber);

            this.server('register', 'POST', formdata)
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
