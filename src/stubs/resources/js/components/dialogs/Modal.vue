<template>

    <div class="modal" v-bind:class="{ 'is-active' : isModalActive}">
        <div class="modal-background" @click="toggleModal"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">{{CONSTANTS.getCopy('ADMIN_MESSAGE')}}</p>
                <button class="delete" aria-label="close" @click="toggleModal"></button>
            </header>
            <section class="modal-card-body">
                {{modalText}}
            </section>
            <footer class="modal-card-foot">
                <button class="button is-primary" @click="toggleModal">{{CONSTANTS.getCopy('ADMIN_ACCEPT')}}</button>
            </footer>
        </div>
    </div>

</template>

<script>

    export default {

        data() {
            return {
                showModal: false,
                modalText: ''
            }
        },

        created() {
            Event.$on('showModal', message => {
                this.showModal = true;
                this.modalText = message ? message : this.modalText;
            });
        },

        computed: {
            isModalActive() {
                return this.showModal;
            }
        },

        methods: {

            toggleModal() {
                this.showModal = !this.showModal;
            }
        }
    }
</script>
