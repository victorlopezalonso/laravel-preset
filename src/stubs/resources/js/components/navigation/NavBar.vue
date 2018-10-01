<template>

    <div>

        <!-- Navbar beginning -->
        <nav class="navbar">

            <div class="navbar-brand">

                <a class="navbar-item">
                    <!--<span class="icon"><i class="fas fa-user-secret fa-2x"></i></span>-->
                    <img src="../../../images/logo-dark.png" class="logo">
                </a>
                <div :class="hamburguerClass" @click="toggleHamburguer">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <div :class="navBarClass">

                <div class="navbar-start">

                    <router-link
                            v-for="item in routes"
                            :key="item.path"
                            :to="item.path"
                            class="navbar-item"
                            :class="{ 'is-active' : isActive(item)}">
                        {{item.name}}
                    </router-link>

                </div>

                <div class="navbar-end">
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            {{user.name}}
                        </a>
                        <div class="navbar-dropdown is-boxed">
                            <a class="navbar-item" @click="logout">
                                Logout
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </nav>
        <!-- End of Navbar-->

        <!-- Hero section -->
        <section class="hero is-primary is-small">
            <div class="hero-body">
                <p class="title">
                    {{routeName}}
                </p>
                <p class="subtitle">
                    {{routeDescription}}
                </p>
            </div>
        </section>

    </div>

</template>

<script>
    export default {
        data() {
            return {
                menuActive: false,
                hide: true,
                items: [],
                user: {
                    'name': '',
                    'permissions': 0
                }
            }
        },

        created() {
            this.user = window.App.user;
            this.setRoutes();
        },

        computed: {
            isHidden() {
                return this.hide;
            },
            routes() {
                return this.items;
            },
            routeName() {
                return this.$route.name;
            },
            routeDescription() {
                return this.$route.meta.description;
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
                return this.$route.path === item.path;
            },
            logout() {
                this.auth.logout();
            },
            setRoutes() {
                this.$router.options.routes.forEach(route => {
                    let isAllowedRoute = route.meta.permissions === this.CONSTANTS.GENERIC_USER.permissions;
                    let isGenericUser = this.user.permissions === this.CONSTANTS.GENERIC_USER.permissions;
                    let userHasEnoughPermissions = this.user.permissions <= route.meta.permissions;

                    if (isAllowedRoute || (!isGenericUser && userHasEnoughPermissions)) {
                        this.items.push({name: route.name, path: route.path});
                    }
                });
            }
        },
    }
</script>

<style>

    img.brand {
        width: 150px !important;
        display: block;
        margin: 0 auto
    }

    img.logo {
        width: auto;
        height: 28px;
    }

</style>
