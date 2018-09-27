<template>

    <div class="container">

        <!-- Title -->
        <div class="field">
            <label class="label">Title</label>

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
            <label class="label">Header</label>

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
            <label class="label">Content</label>

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
            <label class="label">Image</label>
            <div class="file is-info has-name is-fullwidth">
                <label class="file-label">
                    <input ref="image" class="file-input" type="file" name="resume" accept="image/*" @change="setImage">
                    <span class="file-cta">
                    <span class="file-icon"><i class="fas fa-upload"></i></span>
                    <span class="file-label">Choose an image...</span>
                </span>
                    <span class="file-name">{{imageName}}</span>
                </label>
            </div>
        </div>

        <!-- URL -->
        <div class="field">
            <label class="label">Link</label>
            <div class="control has-icons-left">
                <input class="input" type="text" placeholder="Url to open when the app receives the push notification"
                       v-model="push.url">
                <span class="icon is-small is-left"><i class="fas fa-link fa-lg"></i></span>
            </div>
        </div>

        <!-- Send notification -->
        <div class="button is-primary" @click="sendNotification">
            <!--<span class="icon"><i class="fas fa-upload fa-lg"></i></span>-->
            <span>Send notification</span>
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