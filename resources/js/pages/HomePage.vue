<template>
    <div class="container">
        <div class="form-cont">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center mb-5">
                        Доступные места для конференций
                    </h3>
                    <div class="container">
                        <div class="row">
                            <div
                                class="col-lg-6 col-sm-12 d-flex flex-column align-items-center"
                                v-if="places=={}"
                                v-for="place in places"
                            >
                                <div
                                    class="d-flex flex-column align-items-center align-items-lg-start"
                                >
                                    <img
                                        :src="PUBLIC + place.image"
                                        width="350px"
                                        alt=""
                                    />
                                    <h4>{{ place.title }}</h4>
                                    <p>{{ place.description }}</p>
                                </div>
                            </div>
                            <section class="p-5 my-5" v-else>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            <h3 class="text-center p-4">
                                                Администратор еще не добавил
                                                доступные места для конференций
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "HomePage",
    data() {
        return {
            places: {},
        };
    },
    props: ["PUBLIC", "changePage"],
    mounted() {},
};
</script>
