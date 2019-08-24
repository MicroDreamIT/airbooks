<template>
    <div class="chart-container" >
        <canvas id="udLineChart"
                width="80" height="23"
                class="chartjs-render-monitor"
        >

        </canvas>
    </div>
</template>

<script>
    export default{
        props:['data'],
        data(){
            return{
                labelsData:[],
                chartData:[],

            }

        },
        created(){
            this.data.forEach(data=>{
                this.labelsData.push(data.month)
                this.chartData.push(data.users)
            })
        },
        mounted(){
            let ctx = document.getElementById("udLineChart");
            var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: this.labelsData,
                    datasets: [{
                        data: this.chartData,
                        label: "Users",
                        borderColor: "#8e5ea2",
                        fill: false
                    }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero:true
                            }
                        }]
                    }
                }
            });
        }
    }
</script>
