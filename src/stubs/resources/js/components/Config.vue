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
                <input class="input" type="email" placeholder="" v-model="config.deepLinkUrl">
                <span class="icon is-small is-left"><i class="fas fa-link fa-lg"></i></span>
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
                    deepLinkUrl: null
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
