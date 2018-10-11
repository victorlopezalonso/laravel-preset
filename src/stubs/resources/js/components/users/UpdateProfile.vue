<template>

    <confirm title="Edit User" ok="Save user" :show="show"
             v-on:save="save"
             v-on:close="close">

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_NAME')}}</label>
            <div class="control">
                <input class="input" type="text" placeholder="User name" v-model="data.name">
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('LAST_NAME')}}</label>
            <div class="control">
                <input class="input" type="text" placeholder="last name" v-model="data.lastname">
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_EMAIL')}}</label>
            <div class="control">
                <input class="input" type="email" placeholder="email" v-model="data.email">
            </div>
        </div>

        <div class="field" v-if="hasRootPermissionsAndIsNotRoot()">
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
    export default {

        props: {
            show: Boolean,
            data: Object,
        },

        data() {
            return {}
        },

        computed: {

        },

        methods: {
            save() {
                this.$emit('save', this.data);
            },
            close() {
                this.$emit('close');
            },
            hasRootPermissionsAndIsNotRoot() {
                return this.CONSTANTS.hasRootPermissions() && this.data.permissions !== this.CONSTANTS.ROOT_USER.permissions;
            }
        }
    }
</script>
