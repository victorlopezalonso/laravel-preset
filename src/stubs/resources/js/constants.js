let GENERIC_USER = {permissions: 0, role: 'User'};
let ROOT_USER = {permissions: 1, role: 'Root'};
let ADMIN_USER = {permissions: 2, role: 'Admin'};
let CONSULTANT_USER = {permissions: 3, role: 'Consultant'};

let getUserType = function (permissions) {

    switch (permissions) {

        case GENERIC_USER.permissions:
            return GENERIC_USER.role;

        case ROOT_USER.permissions:
            return ROOT_USER.role;

        case ADMIN_USER.permissions:
            return ADMIN_USER.role;

        case CONSULTANT_USER.permissions:
            return CONSULTANT_USER.role;

        default:
            return 'No role assigned';
    }
};

let hasRootPermissions = function () {
    return window.App.user.permissions === ROOT_USER.permissions;
};

let COPY_TYPE = {CLIENT: 0, SERVER: 1, ADMIN: 2};

export default {

    getUserType, hasRootPermissions,

    GENERIC_USER, ROOT_USER, ADMIN_USER, CONSULTANT_USER,

    PERMISSIONS: [GENERIC_USER, ROOT_USER, ADMIN_USER, CONSULTANT_USER],

    COPY_TYPE,

}
