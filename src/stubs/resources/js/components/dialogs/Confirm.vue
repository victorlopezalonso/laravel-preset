<template>

    <div class="modal" :class="{'is-active' : show}">
        <div class="modal-background" @click="close"></div>
        <div class="modal-card">

            <header class="modal-card-head">
                <p class="modal-card-title">{{titleText}}</p>
                <button class="delete" aria-label="close" @click="close"></button>
            </header>

            <section class="modal-card-body">
                <slot/>
            </section>

            <footer class="modal-card-foot">
                <button class="button is-primary" @click="save">{{okText}}</button>
                <button class="button" @click="close">{{cancelText}}</button>
            </footer>

        </div>
    </div>

</template>

<script>

    export default {

        props: {
            show: Boolean,
            title: String,
            ok: String,
            cancel: String,
        },

        computed: {
            titleText() {
                return this.title ? this.title : 'Confirm';
            },
            okText() {
                return this.ok ? this.ok : 'OK';
            },
            cancelText() {
                return this.cancel ? this.cancel : 'Cancel';
            }
        },

        methods: {
            save() {
                this.$emit('save');
            },
            close() {
                this.$emit('close');
            }
        }
    }
</script>