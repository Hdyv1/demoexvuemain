<template>
    <h2 class="text-center mb-3">Создание заявки</h2>
    <div class="container">
        <div class="row authForm">
            <div class="col-12 form-control p-3">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label" for="place"
                                >Выберите место проведения</label
                            >
                            <select
                                class="form-select"
                                name="place"
                                id="place"
                                v-model="place"
                            >
                                <option selected value="0">
                                    Откройте меню выбора места
                                </option>
                                <option
                                    v-for="place in places"
                                    :value="place.id"
                                >
                                    {{ place.title }}
                                </option>
                            </select>
                            <div class="alert alert-danger" v-if="errors.place">
                                {{ errors.place.join(". ") }}
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="name"
                                >Напишите название мероприятия</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                placeholder="Мероприятие"
                                v-model="name"
                            />
                            <div class="alert alert-danger" v-if="errors.name">
                                {{ errors.name.join(". ") }}
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="date"
                                >Выберите дату проведения</label
                            >
                            <input
                                id="date"
                                type="datetime-local"
                                class="form-control"
                                name="date"
                                v-model="date"
                            />
                            <div class="alert alert-danger" v-if="errors.date">
                                {{ errors.date.join(". ") }}
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" for="payMethod"
                                >Способ оплаты</label
                            >
                            <select
                                class="form-select"
                                name="payMethod"
                                id="payMethod"
                                v-model="payMethod"
                            >
                                <option selected value="cash">Наличные</option>
                                <option value="card">СБП</option>
                            </select>
                            <div
                                class="alert alert-danger"
                                v-if="errors.payMethod"
                            >
                                {{ errors.payMethod.join(". ") }}
                            </div>
                        </div>
                        <div class="col-12">
                            <button
                                type="submit"
                                class="btn btn-primary"
                                @click="[orderCreate()]"
                            >
                                Отправить
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "OrderPage",
    data() {
        return {
            places: {},
            place: 0,
            date: null,
            payMethod: null,
            name: null,
            errors: {},
        };
    },
    methods: {
        orderCreate() {
            let formdata = new FormData();
            if (this.place) formdata.append("place", this.place);
            if (this.date) formdata.append("date", this.date);
            if (this.payMethod) formdata.append("payMethod", this.payMethod);
            if (this.name) formdata.append("name", this.name);
            this.server("orderCreate", "POST", formdata).then((result) => {
                if (result.errors) {
                    this.errors = result.errors;
                }
                else if (result) {
                    // console.log(result);
                    this.changePage('OrdersPage');
                }
            });
        },
        getPlaces() {
            this.server("Places").then((result) => {
                if (result) {
                    this.places = result;
                    console.log(result);
                }
            });
        },
    },
    props: ["PUBLIC", "changePage", "server"],
    mounted() {
        this.getPlaces();
    },
};
</script>
