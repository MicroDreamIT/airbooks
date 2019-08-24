<template>
    <div class="chart-container" >
        <canvas id="udChart" width="30" height="14"></canvas>
    </div>
</template>

<script>
    export default{
        props:['data'],
        data(){
            return{


            }

        },
        mounted(){
            let ctx = document.getElementById("udChart");
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ["Free Plan", "Personal Plan", "Corporate Plan"],
                    datasets: [{
                        label: '# of Votes',
                        data: this.data,
                        backgroundColor: [
                            'rgba(135, 31, 234)',
                            'rgba(41, 171, 228)',
                            'rgba(241, 90, 36)',

                        ],
                        borderColor: [
                            'rgba(135, 31, 234)',
                            'rgba(41, 171, 228)',
                            'rgba(241, 90, 36)',

                        ],
                        borderWidth: 2
                    }]
                },

                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                padding: 0,
                            },
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                                drawTicks: false,
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                color: "rgba(0, 0, 0, 0)",
                                drawTicks: false,
                            },
                            ticks: {
                                padding: 0,
                                display:false
                            },
                        }],
                    },

                    legend:{
                        position:'bottom',
                        labels:{
                            boxWidth:10
                        }
                    },
                    cutoutPercentage:75,

                }
            });
        }
    }
</script>