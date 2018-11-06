<template>

    <confirm title="Create User" ok="Save user" :show="show"
             v-on:save="save"
             v-on:close="close">

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_NAME')}}</label>
            <div class="control">
                <input class="input" type="text" placeholder="User name" v-model="data.name">
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_EMAIL')}}</label>
            <div class="control">
                <input class="input" type="email" placeholder="email" v-model="data.email">
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_PASSWORD')}}</label>
            <div class="control">
                <input class="input" type="password" placeholder="password" v-model="data.password">
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_PERMISSIONS')}}</label>
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
                this.data = new User();
            },
            close() {
                this.data = new User();
                this.$emit('close');
            }
        }
    }
</script>
