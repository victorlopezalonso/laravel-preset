<template>

    <nav class="pagination" role="navigation" aria-label="pagination">

        <button class="pagination-previous" :disabled="isFirstPage" @click="navigatePrev">
            &laquo; Previous
        </button>

        <button class="pagination-next" :disabled="isLastPage" @click="navigateNext">
            Next page &raquo;
        </button>

        <ul class="pagination-list"></ul>

    </nav>

</template>

<script>

    export default {

        props: ['paginator'],

        computed: {
            isFirstPage() {
                return this.paginator.current === 1;
            },
            isLastPage() {
                return this.paginator.total === 0 || this.paginator.current === this.paginator.total;
            },
        },

        methods: {

            navigatePrev() {
                this.$emit('prev', this.paginator.prev);
            },

            navigateNext() {
                this.$emit('next', this.paginator.next);
            }

        }
    }
</script>

<style scoped>

</style>