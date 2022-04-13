window.onload = function () {
    if (alunos) {
        alunos = parseInt(alunos);
        evadidos = parseInt(evadidos);

        var ctx = document.getElementById('alunosevadidos').getContext('2d');
        var myChart1 = new Chart(ctx, {
            type: 'bar',
            plugins: [ChartDataLabels],
            data: {
                labels: ['Ativo', 'Evadido'],
                datasets: [{
                    label: 'Ativos vs Evadidos',
                    data: [alunos - evadidos, evadidos],
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
                        text: 'Ativos vs Evadidos'
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