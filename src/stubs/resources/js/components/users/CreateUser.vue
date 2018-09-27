<template>

    <confirm title="Create User" ok="Save user" :show="show"
             v-on:save="save"
             v-on:close="close">

        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" placeholder="User name" v-model="data.name">
            </div>
        </div>

        <div class="field">
            <label class="label">Email</label>
            <div class="control">
                <input class="input" type="email" placeholder="email" v-model="data.email">
            </div>
        </div>

        <div class="field">
            <label class="label">Password</label>
            <div class="control">
                <input class="input" type="password" placeholder="password" v-model="data.password">
            </div>
        </div>

        <div class="field">
            <label class="label">Permissions</label>
            <div class="control">
                <div class="select">
                    <select class="select" v-model="data.permissions">
                        <option v-for="permissions in CONSTANTS.PERMISSIONS"
                                :selected="data.permissions === permissions.permissions"
                                :value="permissions.permissions">{{permissions.role}}
                        </option>
                    </select>
                </div>
            </div>
        </div>

    </confirm>
</template>

<script>
    import User from "../../models/user";

    export default {

        props: {
            show: Boolean
        },

        data() {
            return {
                data: new User()
            }
        },

        methods: {
            save() {
                this.$emit('save', this.data);
            },
            close() {
                this.data = new User();
                this.$emit('close');
            }
        }
    }
</script>