<template>

    <div class="container">

        <!-- Title -->
        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_TITLE')}}</label>

            <div v-for="language in languages" class="field has-addons">
                <p class="control">
                    <a class="button is-static">{{language}}</a>
                </p>
                <p class="control is-expanded">
                    <input class="input" type="text" v-model="push.title[language]">
                </p>
            </div>
        </div>
        <br>

        <!-- Header -->
        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_HEADER')}}</label>

            <div v-for="language in languages" class="field has-addons">
                <p class="control">
                    <a class="button is-static">{{language}}</a>
                </p>
                <p class="control is-expanded">
                    <input class="input" type="text" v-model="push.header[language]">
                </p>
            </div>
        </div>
        <br>

        <!-- Content -->
        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_CONTENT')}}</label>

            <div v-for="language in languages" class="field has-addons">
                <p class="control">
                    <a class="button is-static">{{language}}</a>
                </p>
                <p class="control is-expanded">
                    <textarea class="textarea" v-model="push.content[language]"></textarea>

                </p>
            </div>
        </div>
        <br>

        <!-- Image -->
        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_IMAGE')}}</label>
            <div class="file is-info has-name is-fullwidth">
                <label class="file-label">
                    <input ref="image" class="file-input" type="file" name="resume" accept="image/*" @change="setImage">
                    <span class="file-cta">
                    <span class="file-icon"><i class="fas fa-upload"></i></span>
                    <span class="file-label">{{CONSTANTS.getCopy('ADMIN_CHOOSE_IMAGE')}}</span>
                </span>
                    <span class="file-name">{{imageName}}</span>
                </label>
            </div>
        </div>

        <!-- URL -->
        <div class="field">
            <label class="label is-capitalized">{{CONSTANTS.getCopy('ADMIN_LINK')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" :placeholder="CONSTANTS.getCopy('ADMIN_LINK_DESCRIPTION')"
                       v-model="push.url">
                <span class="icon is-small is-left"><i class="fas fa-link fa-lg"></i></span>
            </div>
        </div>

        <!-- Send notification -->
        <div class="button is-primary" @click="sendNotification">
            <!--<span class="icon"><i class="fas fa-upload fa-lg"></i></span>-->
            <span>{{CONSTANTS.getCopy('ADMIN_SEND_NOTIFICATION')}}</span>
        </div>

    </div>

</template>

<script>

    import Push from '../models/push';

    export default {
        data() {
            return {
                languages: [],
                push: new Push,
                imageName: null
            }
        },

        mounted() {
            this.api.get('/config/languages').then(response => {
                this.languages = response.data;
            });
        },

        methods: {
            sendNotification() {
                this.api.multipart('/pushes', this.push).then(response => {
                    this.push = new Push;
                    Event.$emit('showModal', response.message);
                });
            },

            setImage() {
                let files = this.$refs.image.files;

                if (!files.length) {
                    this.imageName = null;
                    return;
                }

                this.push.image = files[0];
                this.imageName = this.push.image.name;
            }
        }
    }
</script>
