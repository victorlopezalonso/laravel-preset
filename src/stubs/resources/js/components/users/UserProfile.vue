<template>

    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li @click="goToNewPage('/users')">
                    <a>
                        <span class="icon fa-lg">
                          <i class="fas fa-users" aria-hidden="true"></i>
                        </span>
                        <span>{{CONSTANTS.getCopy('ADMIN_USERS')}}</span>
                    </a>
                </li>
                <li class="is-active">
                    <a>
                        <span class="icon fa-lg">
                          <i class="fas fa-user" aria-hidden="true"></i>
                        </span>
                        <span>{{CONSTANTS.getCopy('ADMIN_USER')}} {{user.id}}</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="columns is-gapless is-multiline is-mobile">
            <div class="column is-one-third"></div>
            <div class="column is-one-third"></div>
            <div class="column is-one-third">
                <div class="buttons has-addons is-right">
                    <span class="button is-warning" @click="editUser">
                        <span class="icon"><i class="fas fa-edit fa-lg"></i></span>
                        <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_EDIT')}}</span>
                    </span>
                </div>

            </div>
        </div>

        <div v-if="!editMode" class="columns is-gapless is-multiline is-mobile">
            <div class="column is-one-third"></div>
            <div class="column is-one-third">
                <div class="card">
                    <div class="card-image">
                        <figure class="image is-4by3">
                            <img :src="selectPhoto(user.photo)" alt="Placeholder image">
                        </figure>
                    </div>
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content has-text-centered">
                                <p class="title is-4">{{user.name}}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="column is-one-third"></div>
        </div>

        <div v-if="editMode" class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_PHOTO')}}</label>
            <div class="file is-centered has-name is-boxed">
                <label class="file-label">
                    <input ref="image" class="file-input" type="file" name="photo" accept="image/*" @change="setImage">
                    <span class="file-cta">
                        <span class="file-icon"><i class="fas fa-upload"></i></span>
                        <span class="file-label">{{CONSTANTS.getCopy('ADMIN_CHOOSE_IMAGE')}}</span>
                    </span>
                    <span class="file-name">{{this.imageName}}</span>
                </label>
            </div>
        </div>

        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_PERMISSIONS')}}</label>
            <div class="control">
                <div class="select">
                    <select class="select" v-model="user.permissions" :disabled="!editMode">
                        <option v-for="permissions in CONSTANTS.PERMISSIONS"
                                :selected="user.permissions === permissions.permissions"
                                :value="permissions.permissions">{{permissions.role}}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_NAME')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" value="NAME" v-model="user.name" :readonly="!editMode">
                <span class="icon is-small is-left"><i class="far fa-user fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_LAST_NAME')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" value="LASTNAME" v-model="user.lastname" :readonly="!editMode">
                <span class="icon is-small is-left"><i class="fas fa-user fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_USERNAME')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" value="USERNAME" v-model="user.username" :readonly="!editMode">
                <span class="icon is-small is-left"><i class="fas fa-user-circle fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_EMAIL')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="email" value="EMAIL" v-model="user.email" :readonly="true">
                <span class="icon is-small is-left"><i class="fas fa-envelope fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_BIRTHDATE')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="date" value="DD-MM-AAAA" v-model="user.birthdate" :readonly="!editMode">
                <span class="icon is-small is-left"><i class="fas fa-calendar-alt fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_GENDER')}}</label>
            <div class="control">
                <div class="select">
                    <select class="select" v-model="user.gender" :disabled="!editMode">
                        <option value="0" :selected="!user.gender">
                            <span class="icon is-small is-left"><i class="fas fa-mars fa-lg"></i></span>Male
                        </option>
                        <option value="1" :selected="user.gender">
                            <span class="icon is-small is-left"><i class="fas fa-venus fa-lg"></i></span>Female
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_ADDRESS')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" value="ADDRESS" v-model="user.address" :readonly="!editMode">
                <span class="icon is-small is-left"><i class="fas fa-home fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_CITY')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" value="CITY" v-model="user.city" :readonly="!editMode">
                <span class="icon is-small is-left"><i class="far fa-building fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_COUNTRY')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" value="COUNTRY" v-model="user.country" :readonly="!editMode">
                <span class="icon is-small is-left"><i class="far fa-building fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_POSTCODE')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" value="POSTCODE" v-model="user.postcode" :readonly="!editMode">
                <span class="icon is-small is-left"><i class="far fa-building fa-lg"></i></span>
            </div>
        </div>

        <div v-if="editMode" class="buttons is-centered">
            <span class="button is-success" @click="updateUser">
                <span class="icon"><i class="fas fa-save fa-lg"></i></span>
                <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_SAVE')}}</span>
            </span>
            <span class="button is-danger" @click="cancelEdit">
                <span class="icon"><i class="fas fa-times fa-lg"></i></span>
                <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_CANCEL')}}</span>
            </span>
        </div>

    </div>


</template>

<script>

    import User from "../../models/user";
    import constants from "../../constants";

    export default {

        components: {},

        data() {
            return {
                editMode: false,
                image: null,
                imageName: null,
                user: new User()
            };
        },

        mounted() {
            this.getUser(this.$route.params.id);
            this.editMode = this.$route.query.edit;
        },

        methods: {
            getUser(id) {
                this.api.get('/users/' + id).then(response => {
                    this.user = response.data;
                    if (this.user.photo) {
                        let arr = this.user.photo.split("/");
                        this.imageName = arr[arr.length - 1];
                    }
                });
            },
            selectPhoto(path) {
                if (!path) {
                    return "../../../images/avatar/USER_DEFAULT.png";
                }
                return path;
            },
            setImage() {
                let files = this.$refs.image.files;

                if (!files.length) {
                    this.imageName = null;
                    return;
                }
                console.log('User: ' + this.user);

                this.image = files[0];
                this.imageName = this.image.name;
            },
            editUser() {
                if (this.editMode) {
                    this.cancelEdit();
                } else {
                    this.project = JSON.parse(JSON.stringify(this.user));
                    this.editMode = true;
                }
            },
            cancelEdit() {
                this.editMode = false;
                this.getUser(this.user.id);
            },
            updateUser() {
                this.editMode = false;
                this.api.put('/users/' + this.user.id, this.user).then(() => {
                    this.api.multipart('/users/' + this.user.id, {'photo': this.image}).then(() => {
                        this.getUser(this.user.id)
                    })
                });
            },
            goToNewPage(page, id){
                this.$router.push({path: page, query: {id: id}});
            }
        },
    }
</script>
