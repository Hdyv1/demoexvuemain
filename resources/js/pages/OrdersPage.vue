<template>
    <h2 class="text-center">Просмотр заявок</h2>
    <div class="container">
        <div class="row form-cont">
            <div
                class="col-12 form-control mb-3 p-3"
                v-for="order in orders"
                v-if="orders[0]"
            >
                <div class="order">
                    <h5>Место - {{ order.place.title }} ({{ created_at(order.date) }})</h5>
                    <p>
                        Способ Оплаты:
                        {{ order.payMethod == "cash" ? "Наличные" : "СБП" }}
                    </p>
                    <p>Название мероприятия: {{ order.name }}</p>
                    <p>
                        Статус заявки:
                        <span>
                            {{
                                order.status == "new"
                                    ? "Новая"
                                    : order.status == "created"
                                      ? "Создана"
                                      : "Завершено"
                            }}
                        </span>
                    </p>
                </div>
                <div v-if="order.status == 'done'">
                    <textarea
                        placeholder="Здесь вы можете оставить отзыв"
                        class="form-control mb-3"
                        name="content"
                        :id="'content' + order.id"
                        v-model="content[order.id]"
                    ></textarea>
                    <button
                        type="submit"
                        class="btn btn-primary"
                        @click="commentCreate(order.id)"
                    >
                        Отправить
                    </button>
                    <div
                        class="alert alert-danger"
                        v-if="errors[order.id]?.content"
                    >
                        {{ errors[order.id].content.join(". ") }}
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <h4>Отзывы</h4>

                                <div
                                    class="form-control col-12 mb-3"
                                    v-for="comment in order.comments"
                                >
                                    <div
                                        class="comment-header d-flex align-items-center justify-content-between"
                                    >
                                        <h6>{{ comment.user?.fullname }}</h6>
                                        <span class="fw-light"
                                            >{{created_at(comment.created_at)}}</span
                                        >
                                    </div>

                                    {{ comment.content }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="text-center" v-else>У вас еще нет ни одной заявки</h2>
        </div>
    </div>
</template>
<script>
export default {
    name: "OrdersPage",
    data() {
        return {
            orders: {},
            comments: {},
            content: {},
            errors: {},
        };
    },
    methods: {
        commentCreate(id) {
            let formdata = new FormData();
            if (this.content[id]) {
                formdata.append("content", this.content[id]);
            }
            this.server("commentCreate/" + id, "POST", formdata).then(
                (result) => {
                    if (result.errors) {
                        this.errors[id] = result.errors;
                    }
                    if (result) {
                        console.log(result);
                        this.content[id] = '';
                        this.getOrders();
                        // this.changePage('OrdersPage')
                    }
                },
            );
        },
        getOrders() {
            this.server("userOrders").then((result) => {
                if (result) {
                    this.orders = result;
                    console.log(result);
                }
            });
        },
    },
    props: ["PUBLIC", "changePage", "server", 'created_at'],
    mounted() {
        this.getOrders();
    },
};
</script>
