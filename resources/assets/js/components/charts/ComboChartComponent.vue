<template>
    <div class="chart-container">
        <canvas :id="this.id" width="100" height="40"></canvas>
    </div>
</template>
<script>
    export default {
        props: ['labels', 'data1', 'data2', 'type1', 'label', 'id'],
        mounted() {

            let ctx = document.getElementById(this.id)


            new Chart(ctx, {
                type: 'bar',
                data: {
                    datasets: [
                        {
                            label: this.label[0],
                            data: this.data1, //likes
                            backgroundColor: 'rgba(61, 119, 255, 0.68)'
                        },
                        {
                            label: this.label[1],
                            data: this.data2, //fav
                            type: 'line',
                            backgroundColor: 'rgba(158, 0, 0, 0.45)'
                        }
                    ],

                    labels: this.labels
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                            }
                        }]
                    }
                }
            })
        }

    }
</script>

<style>

</style>