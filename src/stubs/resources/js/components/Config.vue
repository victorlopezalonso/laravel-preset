<template>

    <div class="container">

        <div class="field">

            <label class="label">{{CONSTANTS.getCopy('ADMIN_MAINTENANCE_MODE')}}</label>
            <div class="control has-icons-left">
                <div class="select is-medium">
                    <select v-model="config.appInMaintenance">
                        <option :value="false"><span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_NO')}}</span></option>
                        <option :value="true"><span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_YES')}}</span></option>
                    </select>
                </div>
                <span class="icon is-medium is-left">
                <i class="fas fa-wrench"></i>
            </span>
            </div>

            <p class="help is-danger" v-if="config.appInMaintenance">
                {{CONSTANTS.getCopy('ADMIN_MAINTENANCE_WARNING')}}
            </p>

        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_ANDROID_VERSION')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" placeholder="" v-model="config.androidVersion">
                <span class="icon is-small is-left"><i class="fab fa-android fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_IOS_VERSION')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" placeholder="" v-model="config.iosVersion">
                <span class="icon is-small is-left"><i class="fab fa-apple fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_LANGUAGES')}}</label>
            <multi-check :items="config.languages"/>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_CONTACT_MAIL')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" placeholder="" v-model="config.contactMail">
                <span class="icon is-small is-left"><i class="fas fa-envelope fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_FAQ_URL')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" placeholder="" v-model="config.faqUrl">
                <span class="icon is-small is-left"><i class="fas fa-question fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_TERMS_USE_URL')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="text" placeholder="" v-model="config.termsUrl">
                <span class="icon is-small is-left"><i class="fas fa-gavel fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_PRIVACY_URL')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="email" placeholder="" v-model="config.privacyUrl">
                <span class="icon is-small is-left"><i class="fas fa-user-secret fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_DEEPLINK')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="email" placeholder="" v-model="config.deeplinkUrl">
                <span class="icon is-small is-left"><i class="fas fa-link fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_LINKEDIN_URL')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="email" placeholder="" v-model="config.linkedinUrl">
                <span class="icon is-small is-left"><i class="fab fa-linkedin fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_TWITTER_URL')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="email" placeholder="" v-model="config.twitterUrl">
                <span class="icon is-small is-left"><i class="fab fa-twitter fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_FACEBOOK_URL')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="email" placeholder="" v-model="config.facebookUrl">
                <span class="icon is-small is-left"><i class="fab fa-facebook fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_INSTAGRAM_URL')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="email" placeholder="" v-model="config.instagramUrl">
                <span class="icon is-small is-left"><i class="fab fa-instagram fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_YOUTUBE_URL')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="email" placeholder="" v-model="config.youtubeUrl">
                <span class="icon is-small is-left"><i class="fab fa-youtube fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <label class="label">{{CONSTANTS.getCopy('ADMIN_WEB_URL')}}</label>
            <div class="control has-icons-left">
                <input class="input" type="email" placeholder="" v-model="config.webUrl">
                <span class="icon is-small is-left"><i class="fas fa-globe fa-lg"></i></span>
            </div>
        </div>

        <div class="field">
            <div class="button is-primary" @click="updateConfig">
                <span class="icon"><i class="fas fa-save fa-lg"></i></span>
                <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_SAVE')}}</span>
            </div>

            <div class="button is-primary" @click="deploy">
                <span class="icon"><i class="fas fa-code-branch fa-lg"></i></span>
                <span>{{CONSTANTS.getCopy('ADMIN_DEPLOY_FROM_REPOSITORY')}}</span>
            </div>

        </div>

    </div>


</template>

<script>

    import MultiCheck from './utilities/MultiCheck';

    export default {

        components: {MultiCheck},

        data() {
            return {
                items: [],
                languages: [],
                config: {
                    appInMaintenance: false,
                    androidVersion: null,
                    iosVersion: null,
                    languages: null,
                    contactMail: null,
                    faqUrl: null,
                    termsUrl: null,
                    privacyUrl: null,
                    deeplinkUrl: null,
                    linkedinUrl: null,
                    twitterUrl: null,
                    facebookUrl: null,
                    instagramUrl: null,
                    youtubeUrl: null,
                    webUrl: null,
                }
            };
        },

        mounted() {
            this.getConfig();
        },

        methods: {
            getConfig() {
                this.api.get('/config')
                    .then(response => {
                        this.config = response.data;
                    });
            },
            deploy() {
                this.api.post('/config/deploy').then(response => {
                    Event.$emit('showModal', response.message);
                });
            },
            updateConfig() {
                let config = JSON.parse(JSON.stringify(this.config));

                let languages = [];

                this.config.languages.forEach((language) => {
                    if (language.checked === true) {
                        languages.push(language.key);
                    }
                });

                config.languages = languages;

                this.api.put('/config', config).then(response => {
                    this.config = response.data
                });
            }
        },
    }
</script>
