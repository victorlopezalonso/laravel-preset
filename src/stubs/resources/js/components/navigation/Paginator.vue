<template>

    <nav v-if="this.paginator.total > 1" class="pagination" role="navigation" aria-label="pagination">

        <button class="pagination-previous" :disabled="isFirstPage" @click="navigatePrev">
            <label class="is-capitalized">&laquo; {{CONSTANTS.getCopy('ADMIN_PREVIOUS_PAGE')}}</label>
        </button>

        <button class="pagination-next" :disabled="isLastPage" @click="navigateNext">
            <label class="is-capitalized">{{CONSTANTS.getCopy('ADMIN_NEXT_PAGE')}} &raquo;</label>
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
