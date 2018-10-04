<template>

    <div class="container">

        <!-- Add text modal -->
        <confirm title="Add text" ok="Save text" :show="modal"
                 v-on:save="addCopy"
                 v-on:close="initCopyModel">

            <!-- key -->
            <div class="field has-addons">
                <p class="control">
                    <a class="button is-static">key</a>
                </p>
                <p class="control is-expanded">
                    <input class="input" type="text" placeholder="Key" v-model="newCopy.key">
                </p>
            </div>

            <!-- languages -->
            <div v-for="language in languages" class="field has-addons">
                <p class="control">
                    <a class="button is-static">{{language}}</a>
                </p>
                <p class="control is-expanded">
                    <input class="input" type="text" v-model="newCopy[language]">
                </p>
            </div>

            <!-- Check as server text -->
            <div class="control">
                <div class="select">
                    <select v-model="newCopy.type">
                        <option :value="CONSTANTS.COPY_TYPE.CLIENT">Client</option>
                        <option :value="CONSTANTS.COPY_TYPE.SERVER">Server</option>
                        <option :value="CONSTANTS.COPY_TYPE.ADMIN">Admin</option>
                    </select>
                </div>
            </div>

        </confirm>

        <!-- Add text, import/export buttons -->
        <div class="level">

            <div class="level-left">

                <div class="level-item">
                    <div class="button is-primary" @click="modal=!modal">
                        <span class="icon"><i class="fas fa-plus fa-lg"></i></span>
                        <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_ADD')}} {{CONSTANTS.getCopy('ADMIN_COPY')}}</span>
                    </div>
                </div>

            </div>

            <div class="level-right">

                <div class="level-item">
                    <div class="file is-info">
                        <label class="file-label">
                            <input ref="import" class="file-input" type="file" accept=".xls, .xlsx"
                                   @change="uploadExcel">
                            <span class="file-cta">
                                    <span class="file-icon"><i class="fas fa-upload fa-lg"></i></span>
                                    <span class="file-label is-capitalized">{{CONSTANTS.getCopy('IMPORT_FROM_FILE')}}</span>
                                </span>
                        </label>
                    </div>
                </div>

                <div class="level-item">
                    <div class="button is-info" @click="exportExcel">
                        <span class="icon"><i class="fas fa-download fa-lg"></i></span>
                        <span class="is-capitalized">{{CONSTANTS.getCopy('DOWNLOAD_INTO_FILE')}}</span>
                    </div>
                </div>

            </div>

        </div>
        <!-- End Add text, import/export buttons -->

        <!-- Search text -->
        <div class="field has-addons">

            <!-- search icon -->
            <div class="control">
                <a class="button">
                    <span class="icon"><i class="fas fa-search"></i></span>
                </a>
            </div>

            <!-- input  -->
            <div class="control is-expanded">
                <input class="input" type="text" placeholder="Find text"
                       v-model="textFilter"
                       v-on:keyup.esc="textFilter=null">
            </div>

            <!-- cancel icon -->
            <div class="control">
                <a class="button">
                    <span class="icon"><i class="fas fa-times"></i></span>
                </a>
            </div>

        </div>

        <!-- Show server copies -->
        <div class="control">
            <div class="select">
                <select v-model="copyType">
                    <option :value="CONSTANTS.COPY_TYPE.CLIENT">Client</option>
                    <option :value="CONSTANTS.COPY_TYPE.SERVER">Server</option>
                    <option :value="CONSTANTS.COPY_TYPE.ADMIN">Admin</option>
                </select>
            </div>
        </div>

        <br>

        <!-- List of copies -->
        <div v-for="copy in copies">

            <!-- icon and copy key -->
            <div class="level">
                <div class="level-left">

                    <!-- server/client icon -->
                    <div class="level-item">
                        <p>
                            <span class="icon" v-if="copy.type === CONSTANTS.COPY_TYPE.SERVER"><i class="fas fa-database fa-2x"></i></span>
                            <span class="icon" v-else-if="copy.type === CONSTANTS.COPY_TYPE.CLIENT"><i class="fas fa-mobile fa-2x"></i></span>
                            <span class="icon" v-else-if="copy.type === CONSTANTS.COPY_TYPE.ADMIN"><i class="fas fa-user-secret fa-2x"></i></span>
                        </p>
                    </div>

                    <!-- copy key -->
                    <div class="level-item">
                        <p><strong>{{copy.key}}</strong></p>
                    </div>
                </div>
            </div>

            <!-- copy languages -->
            <div v-for="language in languages" class="field has-addons">

                <p class="control">
                    <a class="button is-static">{{language}}</a>
                </p>
                <p class="control is-expanded">
                    <input class="input" type="text" v-model="copy[language]" :disabled="!isEditing(copy)">
                </p>

            </div>

            <!-- action buttons -->
            <div class="buttons is-right">

                <span class="button is-light" v-if="!isEditing(copy)"
                      @click="editCopy(copy)">
                    <span class="icon"><i class="fas fa-edit fa-lg"></i></span>
                    <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_EDIT')}}</span>
                </span>

                <span class="button is-danger" v-if="isEditing(copy)"
                      @click="cancelEditCopy">
                    <span class="icon"><i class="fas fa-times fa-lg"></i></span>
                    <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_CANCEL')}}</span>
                </span>

                <span class="button is-success" v-if="isEditing(copy)"
                      @click="updateCopy(copy)">
                    <span class="icon"><i class="fas fa-save fa-lg"></i></span>
                    <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_SAVE')}}</span>
                </span>

                <span class="button is-light" v-if="!isEditing(copy) && (copy.type !== CONSTANTS.COPY_TYPE.SERVER)"
                      @click="deleteCopy(copy)">
                    <span class="icon"><i class="fas fa-trash-alt fa-lg"></i></span>
                    <span class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_DELETE')}}</span>
                </span>

            </div>

        </div>

        <paginator :paginator="paginator" v-on:prev="navigatePrev" v-on:next="navigateNext"/>

    </div>

</template>

<script>
    import constants from "../constants";

    export default {
        data() {
            return {
                copyType: 0,
                copies: [],
                languages: [],
                modal: false,
                copyModel: null,
                textFilter: null,
                newCopy: {key: null},
                copyBeforeEdition: null,
                paginator: {
                    current: 1,
                    total: 1,
                    limit: 10,
                }
            }
        },

        mounted() {
            this.getCopies(1);
        },

        watch: {
            copyType: function() {
                this.getCopies(1);
            }
        },

        computed: {

        },

        methods: {
            isEditing(copy) {
                return this.copyBeforeEdition && this.copyBeforeEdition.key === copy.key
            },
            editCopy(copy) {
                this.copyBeforeEdition = JSON.parse(JSON.stringify(copy));
            },
            cancelEditCopy() {
                this.copies.find((object, index) => {
                    if (object.key === this.copyBeforeEdition.key) {
                        this.copies[index] = JSON.parse(JSON.stringify(this.copyBeforeEdition));
                        return true;
                    }
                });

                //terrible hack to update filteredCopies manually
                let filter = JSON.parse(JSON.stringify(this.textFilter));
                this.textFilter = !this.textFilter;
                this.textFilter = filter;

                this.copyBeforeEdition = null;
            },
            getCopies(page) {
                this.api.get('/copies?type=' + this.copyType + '&page=' + page + '&limit=' + this.paginator.limit).then(response => {
                    this.copies = response.data;
                    this.paginator = response.paginator;
                    this.api.get('/copies/params').then(response => {
                        this.languages = response.data.languages;
                        this.copyModel = response.data.copyModel;
                        this.initCopyModel();
                    });
                });
            },
            initCopyModel() {
                this.newCopy = JSON.parse(JSON.stringify(this.copyModel));
                this.modal = false;
            },
            addCopy() {
                this.api.post('/copies', this.newCopy)
                    .then(() => {
                        this.getCopies(this.paginator.current);
                        this.initCopyModel();
                    });
            },
            updateCopy(copy) {
                this.api.put('/copies/' + copy.id, copy)
                    .then(response => {
                        this.copies.find((object, index) => {
                            if (object.key === copy.key) {
                                this.copies[index] = response;
                                return true; // stop searching
                            }
                        });

                        this.copyBeforeEdition = null;
                    });
            },
            deleteCopy(copy) {
                this.api.delete('/copies/' + copy.id)
                    .then(() => {
                        this.copies.find((object, index) => {
                            if (object.key === copy.key) {
                                this.copies.splice(index, 1);
                                return true; // stop searching
                            }
                        });
                    });
            },
            uploadExcel() {
                let files = this.$refs.import.files;

                if (!files.length) {
                    return;
                }

                let file = files[0];

                this.api.multipart('/copies/excel', {'copies': file})
                    .then(response => {
                        this.$refs.import.value = null;
                        Event.$emit('showModal', response.message);
                        this.getCopies(this.paginator.current);
                    });

            },
            exportExcel() {
                this.api.get('/copies/excel')
                    .then(response => {
                        window.location.assign(response.data);
                    });
            },
            navigatePrev(page) {
                this.getCopies(page)
            },
            navigateNext(page) {
                this.getCopies(page)
            }
        },

    }
</script>
