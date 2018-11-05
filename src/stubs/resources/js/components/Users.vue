<template>

    <div class="container">

        <div class="button is-primary" @click="showCreateModal=true" v-if="CONSTANTS.hasRootPermissions()">
            <span class="icon"><i class="fas fa-plus fa-lg"></i></span>
            <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_ADD')}} {{CONSTANTS.getCopy('ADMIN_USER')}}</span>
        </div>
        <br><br>

        <create-user v-if="CONSTANTS.hasRootPermissions()"
                     :show="showCreateModal"
                     v-on:save="addUser"
                     v-on:close="showCreateModal=false"/>

        <table class="table is-striped" style="margin: auto;">

            <thead>
            <tr>
                <th class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_NAME')}}</th>
                <th class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_LAST_NAME')}}</th>
                <th class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_EMAIL')}}</th>
                <th class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_ADMIN')}}</th>
                <th class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_PERMISSIONS')}}</th>
                <th></th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="user in users">
                <td>{{user.name}}</td>
                <td>{{user.lastname}}</td>
                <td>{{user.email}}</td>
                <td>{{user.isAdmin ? 'yes' : 'no'}}</td>
                <td>{{userPermissions(user)}}</td>
                <td>
                    <div class="button is-info" @click="editUser(user)">
                        <span class="icon"><i class="far fa-edit"></i></span>
                        <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_EDIT')}}</span>
                    </div>
                </td>
                <td>
                    <div class="button is-danger" @click="deleteUser(user)">
                        <span class="icon"><i class="far fa-trash-alt"></i></span>
                        <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_DELETE')}}</span>
                    </div>
                </td>
            </tr>
            </tbody>

        </table>

        <paginator :paginator="paginator" v-on:prev="navigatePrev" v-on:next="navigateNext"/>

        <update-profile :data="user" :show="showUpdateModal" v-on:save="updateUser" v-on:close="showUpdateModal=false"/>

    </div>

</template>

<script>

    import UpdateProfile from './users/UpdateProfile';
    import CreateUser from './users/CreateUser';
    import User from '../models/user';

    export default {
        components: {UpdateProfile, CreateUser},
        data() {
            return {
                showUpdateModal: false,
                showCreateModal: false,
                users: [],
                user: new User(),
                paginator: {
                    current: 1,
                    total: 1,
                    limit: 10,
                }
            }
        },

        mounted() {
            this.goToPage(1);
        },

        methods: {
            userPermissions(user) {
                return this.CONSTANTS.getUserType(user.permissions);
            },
            addUser(user) {
                this.showCreateModal = false;
                this.api.post('/users', user).then(() => {
                    this.goToPage(this.paginator.current);
                });
            },
            editUser(user) {
                this.user = JSON.parse(JSON.stringify(user));
                this.showUpdateModal = true;
            },
            updateUser(user) {
                this.showUpdateModal = false;
                this.api.put('/users/' + user.id, user).then(() => {
                    this.goToPage(this.paginator.current)
                });
            },
            deleteUser(user) {
                this.$dialog.confirm(this.CONSTANTS.getCopy('ADMIN_DELETE_CONFIRM')).then(() => {
                    this.api.delete('/users/' + user.id).then(() => {
                        this.goToPage(this.paginator.current)
                    });
                });
            },
            navigatePrev(page) {
                this.goToPage(page)
            },
            navigateNext(page) {
                this.goToPage(page)
            },
            goToPage(page) {
                this.api.get('/users?page=' + page + '&limit=' + this.paginator.limit).then(response => {
                    this.users = response.data;
                    this.paginator = response.paginator;
                });
            }
        }
    }
</script>
