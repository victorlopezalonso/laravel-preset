<template>

    <div class="container">

        <chart type="pie" :label="CONSTANTS.getCopy('ADMIN_OPERATING_SYSTEMS')" :data="stats.os" :colors="colors.os"/>

        <chart type="bar" :label="CONSTANTS.getCopy('ADMIN_GENDERS')" :data="stats.genders" :colors="colors.genders"/>

    </div>

</template>

<script>
    import Chart from './utilities/Chart';
    import constants from "../constants";

    export default {
        components: {Chart},
        data() {
            return {
                stats: {
                    os: null,
                    genders: null
                },
                colors: {
                    os: ['rgba(1, 209, 178, 1)', 'rgba(99, 232, 255, 0.4)', 'rgba(255, 206, 86, 0.4)'],
                    genders: ['rgba(99, 232, 255, 0.4)', 'rgba(255, 99, 132, 0.4)', 'rgba(255, 206, 86, 0.4)']
                }
            }
        },

        mounted() {
            this.api.get('/stats?lang=' + constants.language).then(response => {
                this.stats = response.data;
            });

            console.log(this.auth);
        }
    }
</script>
