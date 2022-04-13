window.onload = function () {
    console.log('aqui')
    if (reativadosPagou) {
        var ctx = document.getElementById('reativado').getContext('2d');
        var myChart1 = new Chart(ctx, {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: ['Não pagou', 'Pagou'],
                datasets: [{
                    label: 'pagou vs não pagou',
                    data: [parseInt(reativadosNpagou), parseInt(reativadosPagou)],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Reativados que não pagaram VS os que pagaram'
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
                            dataArr.map(data => {
                                sum += data;
                            });
                            let percentage = (value * 100 / sum).toFixed(2) + "%";
                            return percentage;
                        },

                        color: '#000',
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.yLabel;
                            }
                        }
                    }
                }
            }
        });
    }

}