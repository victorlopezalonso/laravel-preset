<template>

    <div>

        <!-- Navbar beginning -->
        <nav class="navbar">

            <div class="navbar-brand">

                <a class="navbar-item" href="/home">
                    <!--<span class="icon"><i class="fas fa-user-secret fa-2x"></i></span>-->
                    <img src="../../../images/logo-dark.png" class="logo">
                </a>
                <div :class="hamburguerClass" style="color: #20c2ff;" @click="toggleHamburguer">
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
                        {{CONSTANTS.getCopy(item.name)}}
                    </router-link>

                </div>

                <div class="navbar-end" style="margin-left: 0;">
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            {{mainLanguage}}
                        </a>
                        <div class="navbar-dropdown is-boxed">
                            <a v-for="(language,key) in languages" class="navbar-item" @click="setMainLanguage(key)">
                                {{language}}
                            </a>
                        </div>
                    </div>

                </div>

                <div class="navbar-end" style="margin-left: 0;">
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
                    {{CONSTANTS.getCopy($route.name)}}
                </p>
            </div>
        </section>

    </div>

</template>

<script>
    import constants from "../../constants";
    import env from "../../env";

    export default {
        data() {
            return {
                menuActive: false,
                hide: true,
                languages: null,
                mainLanguage: null,
                items: [],
                user: {
                    'name': '',
                    'permissions': 0
                },
            }
        },

        created() {
            this.user = window.App.user;
            this.setAdminCopies();
            this.getLanguages();
            this.mainLanguage = constants.getCopy('ADMIN_LANGUAGES');
        },

        computed: {
            isHidden() {
                return this.hide;
            },
            routes() {
                return this.items;
            },
            routeName() {
                return constants.getCopy(this.$route.name);
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
                this.items = [];
                this.$router.options.routes.forEach(route => {
                    let isHidden = route.meta.hidden;
                    let isAllowedRoute = route.meta.permissions === this.CONSTANTS.GENERIC_USER.permissions;
                    let isGenericUser = this.user.permissions === this.CONSTANTS.GENERIC_USER.permissions;
                    let userHasEnoughPermissions = this.user.permissions <= route.meta.permissions;

                    if (!isHidden && (isAllowedRoute || (!isGenericUser && userHasEnoughPermissions))) {
                        this.items.push({name: route.name, path: route.path});
                    }
                });
            },
            setAdminCopies() {
                this.api.get('/copies/admin').then(response => {
                    constants.setCopies(response.data);
                    this.setRoutes();
                });
            },
            getLanguages() {
                this.api.get('/config/languages').then(response => {
                    this.languages = response.data;
                    console.log(this.languages);
                    this.mainLanguage = this.languages[localStorage.getItem('language')] != null ? this.languages[localStorage.getItem('language')] : this.languages[env.headers.language];
                });
            },
            setMainLanguage(language){
                localStorage.setItem('language', language);
                console.log('Idioma cambiado a: ' + localStorage.getItem('language'));
                this.$router.go();
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
