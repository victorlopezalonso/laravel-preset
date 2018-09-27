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
            <div class="field">
                <label class="checkbox">
                    <input type="checkbox" v-model="newCopy.server"> Server text
                </label>
            </div>

        </confirm>

        <!-- Add text, import/export buttons -->
        <div class="level">

            <div class="level-left">

                <div class="level-item">
                    <div class="button is-primary" @click="modal=!modal">
                        <span class="icon"><i class="fas fa-plus fa-lg"></i></span>
                        <span>Add text</span>
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
                                    <span class="file-label">Import from file</span>
                                </span>
                        </label>
                    </div>
                </div>

                <div class="level-item">
                    <div class="button is-info" @click="exportExcel">
                        <span class="icon"><i class="fas fa-download fa-lg"></i></span>
                        <span>Download into a file</span>
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
                <input class="input" type="text" placeholder="Find text (Esc to cancel)"
                       v-model="textFilter"
                       v-on:keyup.esc="textFilter=null">
            </div>

            <!-- cancel icon -->
            <div class="control" @click="textFilter=null">
                <a class="button">
                    <span class="icon"><i class="fas fa-times"></i></span>
                </a>
            </div>

        </div>

        <!-- Show server copies -->
        <div class="field">
            <label class="checkbox">
                <input type="checkbox" v-model="showServerCopies">
                Show server texts
            </label>
        </div>

        <br>

        <!-- List of copies -->
        <div v-for="copy in filteredCopies">

            <!-- icon and copy key -->
            <div class="level">
                <div class="level-left">

                    <!-- server/client icon -->
                    <div class="level-item">
                        <p>
                            <span class="icon" v-if="copy.server"><i class="fas fa-database fa-2x"></i></span>
                            <span class="icon" v-if="!copy.server"><i class="fas fa-mobile fa-2x"></i></span>
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
                    <span>Edit</span>
                </span>

                <span class="button is-danger" v-if="isEditing(copy)"
                      @click="cancelEditCopy">
                    <span class="icon"><i class="fas fa-times fa-lg"></i></span>
                    <span>Cancel</span>
                </span>

                <span class="button is-success" v-if="isEditing(copy)"
                      @click="updateCopy(copy)">
                    <span class="icon"><i class="fas fa-save fa-lg"></i></span>
                    <span>Save</span>
                </span>

                <span class="button is-light" v-if="!isEditing(copy) && !copy.server"
                      @click="deleteCopy(copy)">
                    <span class="icon"><i class="fas fa-trash-alt fa-lg"></i></span>
                    <span>Delete</span>
                </span>

            </div>

        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                copies: [],
                languages: [],
                modal: false,
                copyModel: null,
                textFilter: null,
                newCopy: {key: null},
                showServerCopies: false,
                copyBeforeEdition: null
            }
        },

        mounted() {
            this.getCopies()
        },

        computed: {

            filteredCopies() { // Filter copies by text and type (server/client)

                self = this;

                return this.copies.filter(function (copy) {

                    if (!self.showServerCopies && copy.server) return false;

                    if (!self.textFilter) return true;

                    if (((copy.key.search(self.textFilter) > -1)) || (copy.key.toLowerCase().search(self.textFilter) > -1)) {
                        return true;
                    }

                    for (let language in self.languages) {
                        if ((copy[self.languages[language]].search(self.textFilter) > -1) || (copy[self.languages[language]].toLowerCase().search(self.textFilter) > -1)) {
                            return true;
                        }
                    }

                });
            }
        },

        methods: {
            initCopyModel() {
                this.newCopy = JSON.parse(JSON.stringify(this.copyModel));
                this.modal = false;
            },
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
            fetchCopies(response) {
                this.copies = response.copies;
                this.languages = response.languages;
                this.copyModel = response.copyModel;
                this.initCopyModel();
            },
            getCopies() {
                this.api.get('/copies').then(response => this.fetchCopies(response.data));
            },
            addCopy() {
                this.api.post('/copies', this.newCopy)
                    .then(response => {
                        this.copies.push(response);
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
                        this.getCopies();
                    });

            },
            exportExcel() {
                this.api.get('/copies/excel')
                    .then(response => {
                        window.location.assign(response.data);
                    });
            }
        },

    }
</script>