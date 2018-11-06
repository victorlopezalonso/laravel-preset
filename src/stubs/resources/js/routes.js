import VueRooter from 'vue-router';
import CONSTANTS from './constants';

let GENERIC_USER = CONSTANTS.GENERIC_USER.permissions;
let ROOT_USER = CONSTANTS.ROOT_USER.permissions;
let ADMIN_USER = CONSTANTS.ADMIN_USER.permissions;
let CONSULTANT_USER = CONSTANTS.CONSULTANT_USER.permissions;

let routes = [
    {
        name: 'SECTION_HOME',
        path: '/',
        component: require('./components/Home'),
        meta: {
            permissions: GENERIC_USER,
            hidden: false
        }
    },
    {
        name: 'SECTION_SETTINGS',
        path: '/settings',
        component: require('./components/Config'),
        meta: {
            permissions: ROOT_USER,
            hidden: false
        }
    },
    {
        name: 'SECTION_COPIES',
        path: '/copies',
        component: require('./components/Copies'),
        meta: {
            permissions: ADMIN_USER,
            hidden: false
        }
    },
    {
        name: 'SECTION_USERS',
        path: '/users',
        component: require('./components/Users'),
        meta: {
            permissions: ROOT_USER,
            hidden: false
        }
    },
    {
        name: 'SECTION_USER_DETAILS',
        path: '/users/:id',
        component: require('./components/users/UserProfile'),
        meta: {
            'description': 'Detalles del usuario',
            permissions: ADMIN_USER,
            hidden: true
        }
    },
    {
        name: 'SECTION_PUSHES',
        path: '/pushes',
        component: require('./components/Pushes'),
        meta: {
            permissions: ROOT_USER,
            hidden: false
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
