<template>

    <!-- Loading Modal beginning -->
    <div class="modal" v-bind:class="{ 'is-active' : isLoading}">
        <!--<div class="modal-background"></div>-->
        <div class="modal-content">
            <p class="image">
                <img class="brand" src="../../../images/loading.gif" alt="">
            </p>
        </div>
    </div>
    <!-- End of Loading Modal -->

</template>

<script>

    export default {

        data() {
            return {
                showLoading: false
            }
        },

        created() {
            Event.$on('showLoading', () => {
                this.showLoading = true;
            });

            Event.$on('closeLoading', () => {
                this.showLoading = false;
            });
        },

        computed: {
            isLoading() {
                return this.showLoading;
            }
        }
    }
</script>