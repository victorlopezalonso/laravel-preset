// import axios from 'axios';
// import ENV from '../env';

import axios from "axios/index";

let user = window.App.user;

export default {

    install: (Vue) => {

        Vue.prototype.auth = {
            login() {

            },
            isAdmin() {
                return user.is_admin;
            },
            signedIn() {
                return window.App.signedIn;
            },
            logout() {
                axios.post('/logout').then(() => {
                    location.reload();
                }).catch(() => {
                    location.reload();
                });
            }

        }

    }
};