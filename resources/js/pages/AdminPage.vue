<template>
    <h2 class="text-center mb-3">Админ панель</h2>
    <div class="container my-3">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <h3 class="mb-3">
                    {{ this.edit == true ? "Редактирование" : "Создание" }}
                    места
                </h3>
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <label class="form-label" for="title"
                                >Название</label
                            >
                            <input
                                class="form-control"
                                name="title"
                                placeholder="Название места"
                                id="title"
                                value=""
                                v-model="title"
                            />
                            <div class="alert alert-danger" v-if="errors.title">
                                {{ errors.title.join(". ") }}
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="image"
                                >Изображение</label
                            >
                            <input
                                type="file"
                                class="form-control"
                                name="image"
                                id="image"
                            />
                            <div class="alert alert-danger" v-if="errors.image">
                                {{ errors.image.join(". ") }}
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label" for="description"
                                >Описание</label
                            >
                            <textarea
                                class="form-control"
                                name="description"
                                placeholder="Краткое описание"
                                id="description"
                                v-model="description"
                            >
                            </textarea>
                        </div>
                        <div class="col-6">
                            <button
                                type="submit"
                                class="btn btn-primary"
                                @click="
                                    edit
                                        ? placeEdit(this.place.id)
                                        : placeCreate()
                                "
                            >
                                {{ edit ? "Редактировать" : "Создать" }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <h3 class="mb-lg-5 mb-sm-3">Все места</h3>
                <div
                    class="order-form mb-3 form-control p-3"
                    v-for="place in places"
                >
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="order-user">
                                    <p class="fw-semibold fs-4">
                                        {{ place.title }}
                                    </p>
                                    <div class="d-flex">
                                        <p>Описание:</p>
                                        <span class="text-break mx-1">
                                            {{ place.description }}
                                        </span>
                                    </div>
                                </div>
                                <div class="container mt-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <div>
                                                <input type="text" hidden />
                                                <button
                                                    type="submit"
                                                    class="btn btn-primary"
                                                    @click="
                                                        placeEditForm(place.id)
                                                    "
                                                >
                                                    Редактировать
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div>
                                                <input type="text" hidden />
                                                <button
                                                    type="submit"
                                                    class="btn btn-danger"
                                                    @click="
                                                        placeDelete(place.id)
                                                    "
                                                >
                                                    Удалить
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <img :src="place.image" alt="" width="250px" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h3 class="mb-lg-5 mb-sm-3">Все заявки</h3>

                <div
                    class="order-form mb-3 form-control p-3"
                    v-for="order in orders"
                >
                    <div class="order-user">
                        <span>
                            {{ order.user.fullname }} (
                            {{ created_at(order.created_at) }} )</span
                        >
                    </div>
                    <div class="d-flex flex-column">
                        <div>
                            место:
                            <span class="badge bg-secondary">
                                {{ order.place.title }}
                            </span>
                        </div>
                        <div>
                            Название мероприятия:
                            <span class="badge bg-primary">
                                {{ order.name }}
                            </span>
                        </div>
                    </div>

                    <div class="order-status d-flex justify-content-between">
                        <div class="mb-3">
                            <span>Статус заявки: </span>
                            <select
                                class="form-select"
                                name="status"
                                v-model="order.status"
                            >
                                <option value="new">Новое</option>
                                <option value="created">Создано</option>
                                <option value="done">Выполнено</option>
                            </select>
                        </div>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            @click="orderStatusUpdate(order.id, order.status)"
                        >
                            Обновить
                        </button>
                    </div>

                    <div class="comments" v-if="order.comments[0]">
                        <h4>Комментарии</h4>
                        <div class="form-control fw-light">
                            <p v-for="comment in order.comments">
                                {{ comment.user.fullname }}:
                                {{ comment.content }}
                                ({{ created_at(comment.created_at) }})
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12"></div>
        </div>
    </div>
</template>
<script>
export default {
    name: "AdminPage",
    data() {
        return {
            places: {},
            place: null,
            title: null,
            description: null,
            image: null,
            orders: {},
            comments: {},
            errors: {},
            edit: false,
            orders: {},
            status: null,
        };
    },
    components: {},
    props: ["server", "PUBLIC", 'created_at'],
    methods: {
        placeCreate() {
            let formdata = new FormData();
            if (this.title) formdata.append("title", this.title);
            if (this.description)
                formdata.append("description", this.description);
            let image = document.querySelector("#image");
            if (image.files[0]) {
                formdata.append("image", image.files[0]);
            }

            this.server("placeCreate", "POST", formdata).then((result) => {
                if (result.errors) {
                    this.errors = result.errors;
                }
                if (result) {
                    console.log(result);
                    this.getPlaces();
                }
            });
        },
        placeEdit($id) {
            let formdata = new FormData();
            if (this.title) formdata.append("title", this.title);
            if (this.description)
                formdata.append("description", this.description);
            let image = document.querySelector("#image");
            if (image.files[0]) {
                formdata.append("image", image.files[0]);
            }
            this.server("placeEdit/" + $id, "POST", formdata).then((result) => {
                if (result.errors) {
                    this.errors = result.errors;
                } else if (result) {
                    if (this.errors) {
                        this.errors = {};
                    }
                    this.edit = false;
                    this.title = null;
                    this.description = null;
                    this.getPlaces();
                }
            });
        },
        orderStatusUpdate(id, status) {
            let formdata = new FormData();
            if (status) formdata.append("status", status);
            this.server("orderStatusUpdate/" + id, "POST", formdata).then(
                (result) => {
                    if (result) {
                        this.getOrders();
                    }
                },
            );
        },
        placeEditForm($id) {
            this.edit = true;
            this.getEditPlace($id);
        },
        getPlaces() {
            this.server("Places").then((result) => {
                if (result) {
                    this.places = result;
                }
            });
        },
        getOrders() {
            this.server("orders").then((result) => {
                if (result) {
                    this.orders = result;
                }
            });
        },
        getEditPlace($id) {
            this.server("place/" + $id).then((result) => {
                this.place = result;
                this.description = result.description;
                this.title = result.title;
                console.log(result);
            });
        },
        placeDelete($id) {
            this.server("placeDelete/" + $id, "POST").then((result) => {
                if (result) {
                    this.getPlaces();
                }
            });
        },
    },
    mounted() {
        this.getPlaces();
        this.getOrders();
    },
};
</script>
