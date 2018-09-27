<template>
    <div class="container">
        <canvas ref="canvas"></canvas>
    </div>
</template>

<script>
    import Chart from 'chart.js';

    export default {

        props: ['type', 'label', 'data', 'colors'],

        data() {
            return {
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ]
            };
        },

        watch: {

            data: function () {
                this.render();
            }

        },

        methods: {

            initOptions() {

                let options = {};

                switch (this.type) {

                    case('bar'):

                        options = {
                            legend: {
                                display: true,
                                position: 'right',
                            },
                            title: {
                                display: true,
                                text: this.label
                            },
                            scales: {
                                xAxes: [{
                                    stacked: true
                                }],
                                yAxes: [{
                                    stacked: true
                                }]
                            }
                        };

                        break;

                    default:

                        options = {
                            legend: {
                                display: true,
                                position: 'right',
                            },
                            title: {
                                display: true,
                                text: this.label
                            }
                        };
                }

                return options;
            },

            render() {

                let options = this.initOptions();
                let context = this.$refs.canvas.getContext('2d');

                new Chart(context, {
                    type: this.type ? this.type : 'pie',
                    data: {
                        labels: this.data ? this.data.labels : [],
                        datasets: [{
                            label: this.label ? this.label : '',
                            data: this.data ? this.data.values : [],
                            backgroundColor: this.colors ? this.colors : this.backgroundColor,
                            borderColor: this.colors ? this.colors : this.borderColor,
                        }]
                    },
                    options: options
                });

            }
        }

    }
</script>

<style>
    canvas {
        margin-bottom: 50px;
    }
</style>