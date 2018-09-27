<template>
    <div class="wrapper" v-bind:class="{ active: isHidden }">

        <nav id="sidebar" v-bind:class="{ active: isHidden }">

            <h2>Laravel</h2>
            <div id="dismiss" @click="toggleMenu"><i class="fas fa-2x fa-bars"></i></div>

            <ul class="list-unstyled components">

                <li v-for="item in availableRoutes" v-bind:class="{ active : isActive(item)}">
                    <router-link :to="item.route">
                        <span class="menu-icon"><i class="fas fa-home"></i></span>
                        {{item.text}}
                    </router-link>
                </li>
                <!--
                                <li>
                                    <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">Pages</a>
                                    <ul class="collapse list-unstyled" id="homeSubmenu">
                                        <li><a href="#">Page</a></li>
                                        <li><a href="#">Page</a></li>
                                    </ul>
                                </li>
                -->

            </ul>
        </nav>

        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white" @click="toggleMenu">
            <a class="navbar-brand" href="#" v-bind:class="{ active: !isHidden }">
                <i class="fas fa-2x fa-bars"></i>
            </a>

            <div class="navbar-title">{{routeName}}</div>

        </nav>

    </div>

</template>

<script>
    export default {
        data() {
            return {
                hide: true,
                items: [],
                showModal: false,
                modalText: 'This is a text',
                showLoading: false,
                menuActive: false,
                name: ''
            }
        },

        mounted() {
            this.items = [
                {route: "/", text: "Home"},
                {route: "/config", text: "Configuración"},
                {route: "/copies", text: "Textos"},
            ];
        },

        beforeRouteLeave(to, from, next) {
            console.log('leave');
            this.hide = true;
        },

        computed: {
            isMenuActive() {
                return this.menuActive;
            },
            isModalActive() {
                return this.showModal;
            },
            isLoading() {
                return this.showLoading;
            },
            isHidden() {
                return this.hide;
            },
            routes() {
                return this.items;
            },
            routeName() {
                return this.$route.name;
            },
            hamburguerClass() {
                return this.menuActive ? 'navbar-burger burger is-active' : 'navbar-burger burger';
            },
            navBarClass() {
                return this.menuActive ? 'navbar-menu is-active' : 'navbar-menu burger';
            }
        },

        methods: {
            toggleMenu() {
                this.hide = !this.hide;
            },
            toggleHamburguer() {
                this.menuActive = !this.menuActive;
            },
            toggleModal() {
                this.showModal = !this.showModal;
            },
            isActive(item) {
                return this.$route.path === item.route;
            },
            logout() {
                axios.post('/logout').then(response => {
                    location.reload();
                }).catch(error => {
                    location.reload();
                });
            }
        },
    }
</script>

<style>
    .wrapper {
        padding-left: 250px;
        transition: all 0.4s ease 0s;
    }

    .wrapper.active {
        padding-left: 0px;
        transition: all 0.4s ease 0s;
    }

    .navbar.fixed-top {
        z-index: 1;
    }

    .navbar-brand {
        visibility: visible;
        transition: all 0.4s ease 0s;
    }

    .navbar-brand.active {
        visibility: hidden;
        transition: none;
    }

    .navbar {
        border-bottom: solid 1px #ced4da;
        background-color: #ffffff !important;
    }

    .navbar-title {
        text-align: center;
        display: block;
        width: 100%;
    }

    #sidebar {
        background: #18a2b8;
        color: #fff;
        margin-left: -250px;
        left: 250px;
        width: 250px;
        position: fixed;
        height: 100%;
        overflow-y: auto;
        z-index: 1000;
        transition: all 0.4s ease 0s;
    }

    #sidebar.active {
        padding-left: 0;
        margin-left: -250px;
        left: 0;
    }

    #sidebar {
        min-width: 250px;
        max-width: 250px;
        min-height: 100vh;
    }

    #sidebar h2 {
        display: inline-flex;
        margin-left: 12px;
        /*margin-top: 22px;*/
    }

    a[data-toggle="collapse"] {
        position: relative;
    }

    a[aria-expanded="false"]::before, a[aria-expanded="true"]::before {
        content: '\e259';
        display: block;
        position: absolute;
        right: 20px;
        font-size: 0.6em;
    }

    a[aria-expanded="true"]::before {
        content: '\e260';
    }

    p {
        font-size: 1.1em;
        font-weight: 300;
        line-height: 1.7em;
        color: #999;
    }

    a, a:hover, a:focus {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }

    #sidebar {
        background: #18a2b8;
        color: #fff;
        transition: all 0.3s;
    }

    #sidebar .sidebar-header {
        padding: 20px;
        background: #115965;
    }

    #sidebar .sidebar-header h3 {
        display: inline-flex;
    }

    #sidebar ul.components {
        padding: 20px 0;
        border-bottom: 1px solid #fafafa;
    }

    #sidebar ul p {
        color: #fff;
        padding: 10px;
    }

    #sidebar ul li a {
        padding: 10px;
        font-size: 1.1em;
        display: block;
    }

    #sidebar ul li:hover {
        color: #353535;
        background: #fff;
    }

    #sidebar ul li.active > a, a[aria-expanded="true"] {
        color: #fff;
        background: #167f90;
    }

    ul ul a {
        font-size: 0.9em !important;
        padding-left: 30px !important;
        background: #167f90;
    }

    #dismiss {
        position: relative;
        top: 8px;
        left: 111px;
        display: inline-flex;
        cursor: pointer;
    }

</style>