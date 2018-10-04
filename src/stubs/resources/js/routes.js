import VueRooter from 'vue-router';
import CONSTANTS from './constants';

let GENERIC_USER = CONSTANTS.GENERIC_USER.permissions;
let ROOT_USER = CONSTANTS.ROOT_USER.permissions;
let ADMIN_USER = CONSTANTS.ADMIN_USER.permissions;
let CONSULTANT_USER = CONSTANTS.CONSULTANT_USER.permissions;

let routes = [
    {
        name_en: 'Home',
        name_es: 'Inicio',
        path: '/',
        component: require('./components/Home'),
        meta: {
            'description': 'Stats of the app',
            permissions: GENERIC_USER
        }
    },
    {
        name_en: 'Settings',
        name_es: 'Ajustes',
        path: '/settings',
        component: require('./components/Config'),
        meta: {
            'description': 'App settings',
            permissions: ROOT_USER
        }
    },
    {
        name_en: 'Copies',
        name_es: 'Copies',
        path: '/copies',
        component: require('./components/Copies'),
        meta: {
            'description': 'Texts of the client and server side',
            permissions: ADMIN_USER
        }
    },
    {
        name_en: 'Users',
        name_es: 'Usuarios',
        path: '/users',
        component: require('./components/Users'),
        meta: {
            'description': 'Users administration page',
            permissions: ROOT_USER
        }
    },
    {
        name_en: 'Pushes',
        name_es: 'Pushes',
        path: '/pushes',
        component: require('./components/Pushes'),
        meta: {
            'description': 'Push administration page',
            permissions: ROOT_USER
        }
    }
];

const router = new VueRooter({
    routes
});

router.beforeEach((to, from, next) => {

    let userPermissions = window.App.user ? window.App.user.permissions : 0;

    let isAllowedRoute = to.meta.permissions === CONSTANTS.GENERIC_USER.permissions;
    let isGenericUser = userPermissions === CONSTANTS.GENERIC_USER.permissions;
    let userHasEnoughPermissions = userPermissions <= to.meta.permissions;

    if (!isAllowedRoute && (isGenericUser || !userHasEnoughPermissions)) {
        console.log('redirecting home...');
        window.Event.$emit('showModal', 'Access denied');
        // next('/');
        return;
    }

    next(true)
});

export default router;
