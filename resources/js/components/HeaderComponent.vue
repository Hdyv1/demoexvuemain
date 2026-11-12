<template>
    <header class="m-3">
        <div class="container header">
            <div class="row text-center d-flex align-items-center">
                <div class="col-lg-3 col-12-sm mb-3 mb-lg-0">
                    <a href="" @click.prevent="changePage('HomePage')">
                        <img
                            :src="PUBLIC + 'assets/images/etazhi-logotip-vektor-48.jpg'"
                            width="64"
                            height="64"
                            alt=""
                        />
                    </a>
                </div>
                <div class="col-lg-2 col-sm-3 mb-4 mb-lg-0">
                    <a class="a-btn" @click.prevent="changePage('OrdersPage')" href=""
                        >Просмотр заявок</a
                    >
                </div>
                <div class="col-lg-3 col-sm-3 mb-4 mb-lg-0">
                    <a class="a-btn" @click.prevent="changePage(OrderPage)" href=""
                        >Формирование заявки</a
                    >
                </div>
                <div class="col-lg-3 col-sm-3 mb-4 mb-lg-0" v-if="this.user.role=='admin'">
                    <a class="a-btn" href="{{ route('admin') }}"
                        >Панель администратора</a
                    >
                </div>
                <div class="col-lg-1 col-sm-3 mb-4 mb-lg-0">
                    <a class="a-btn" href="" @click="logout()">Выйти</a>
                </div>
            </div>
        </div>
    </header>
</template>
<script>
export default{
    name: "HeaderComponent",
    data(){
        return{
            
        }
    },
    props:['PUBLIC', 'changePage', 'user', 'logout'],
}
</script>