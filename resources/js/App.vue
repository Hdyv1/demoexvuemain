<template>
    <template v-if="isUser">
        <HeaderComponent
            :PUBLIC="PUBLIC"
            :changePage="changePage"
            :user="user"
            :logout="logout"
        />
        <HomePage
            v-if="page == 'HomePage'"
            PUBLIC="PUBLIC"
            :changePage="changePage"
            :server="server"
        />
        <AdminPage
            v-if="page == 'AdminPage'"
            PUBLIC="PUBLIC"
            :server="server"
        />
        <OrderPage
            v-if="page == 'OrderPage'"
            PUBLIC="PUBLIC"
            :changePage="changePage"
            :server="server"
        />
        <OrdersPage
            v-if="page == 'OrdersPage'"
            PUBLIC="PUBLIC"
            :server="server"
        />
    </template>
    <template v-else>
        <AuthPage
            :changePage="changePage"
            :server="server"
            :getUser="getUser"
            :successUser="successUser"
        />
    </template>
</template>

<script>
import HeaderComponent from "./components/HeaderComponent.vue";
import AdminPage from "./pages/AdminPage.vue";
import AuthPage from "./pages/AuthPage.vue";
import HomePage from "./pages/HomePage.vue";
import OrderPage from "./pages/OrderPage.vue";
import OrdersPage from "./pages/OrdersPage.vue";

export default {
    name: "App",
    data() {
        return {
            page: localStorage.getItem("page") || "HomePage",
            pageId: localStorage.getItem("pageId") || "pageId",
            API: "http://127.0.0.1:8000/api/",
            PUBLIC: "http://127.0.0.1:8000/storage/",
            isUser: false,
            isLoad: false,
            user: {},
        };
    },
    methods: {
        changePage(page, pageId = null) {
            this.page = page;
            this.pageId = pageId;
            localStorage.setItem("page", this.page);
            localStorage.setItem("pageId", this.pageId);
        },
        getUser() {
            this.server("user")
                .then((result) => {
                    this.user = result;
                    this.isUser = true;
                    this.isLoad = true;
                    // console.log(this.user);
                })
                .catch((error) => console.error(error));
        },
        successUser(token) {
            localStorage.setItem("token", token);
            this.isUser = true;
            this.getUser();
        },
        logout() {
            localStorage.removeItem("token");
            localStorage.removeItem("page");
            localStorage.removeItem("pageId");
            this.user = {};
            this.isUser = false;
            this.isLoad = true;
        },
        // getPlaces() {
        //     this.server('Place').then((result) => {
        //         this.places = result;
        //     });
        // },
        async server(route, method = "GET", FormData = null) {
            let myHeaders = new Headers();
            myHeaders.append("Accept", "application/json");
            if (localStorage.getItem("token")) {
                myHeaders.append(
                    "Authorization",
                    "Bearer " + localStorage.getItem("token"),
                );
            }

            let requestOptions = {
                method: method,
                headers: myHeaders,
                redirect: "follow",
            };

            if (method != "GET") {
                requestOptions.body = FormData;
            }

            return await fetch(this.API + route, requestOptions).then(
                (response) => {
                    if (response.status == 401) {
                        this.logout();
                    }
                    return response.json();
                },
            );
            // .then((result) => console.log(result))
            // .catch((error) => console.error(error));
        },
    },
    components: {
        HeaderComponent,
        HomePage,
        AuthPage,
        AdminPage,
        OrderPage,
        OrdersPage,
    },
    mounted() {
        if (localStorage.getItem("token")) {
            this.getUser();
        } else {
            this.isLoad = true;
        }
    },
};
</script>
