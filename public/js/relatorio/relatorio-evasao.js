$(document).ready(function () {
    $('table').each(function () {
        var $table = $(this);

        var $button = $("<button type='button' class='mt-2 mb-2 btn btn-primary'>");
        $button.text("Exportar para CSV");
        $button.insertBefore($table);

        $button.click(function () {
            var csv = $table.table2CSV({
                delivery: 'value'
            });
            window.location.href = 'data:text/csv;charset=UTF-8,' +
                encodeURIComponent(csv);
        });
    });
});

window.onload = function () {
    var ctx = document.getElementById('matVSevad').getContext('2d');
    var myChart1 = new Chart(ctx, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
            labels: ['Ativo', 'Cancelados'],
            datasets: [{
                label: 'Ativo vs Cancelados',
                data: [matriculas - evadidos, evadidos],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
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
                    text: 'Ativo vs Cancelados'
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

    // var ctx = document.getElementById('matVSevadGeral').getContext('2d');
    // var myChart1 = new Chart(ctx, {
    //     type: 'bar',
    //     plugins: [ChartDataLabels],
    //     data: {
    //         labels: ['Matriculados', 'Evadidos'],
    //         datasets: [{
    //             label: 'Matriculados VS Evadidos Geral',
    //             data: [matriculas - evadidosGeral, evadidosGeral],
    //             backgroundColor: [
    //                 'rgba(54, 162, 235, 0.2)',
    //                 'rgba(255, 99, 132, 0.2)'
    //             ],
    //             borderColor: [
    //                 'rgba(54, 162, 235, 1)',
    //                 'rgba(255, 99, 132, 1)'
    //             ],
    //             borderWidth: 1
    //         }]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         },
    //         plugins: {
    //             title: {
    //                 display: true,
    //                 text: 'Matriculados vs Evadidos geral'
    //             },
    //             datalabels: {
    //                 formatter: (value, ctx) => {
    //                     let sum = 0;
    //                     let dataArr = ctx.chart.data.datasets[0].data;
    //                     dataArr.map(data => {
    //                         sum += data;
    //                     });
    //                     let percentage = (value * 100 / sum).toFixed(2) + "%";
    //                     return percentage;
    //                 },

    //                 color: '#000',
    //             },
    //             legend: {
    //                 display: false
    //             },
    //             tooltips: {
    //                 callbacks: {
    //                     label: function (tooltipItem) {
    //                         return tooltipItem.yLabel;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // });

    grafInstituicao = JSON.parse(grafInstituicao.replace(/&quot;/g, '"'));
    var ctx = document.getElementById('instituicao').getContext('2d');
    var myChart1 = new Chart(ctx, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
            labels: Object.keys(grafInstituicao.data),
            datasets: [{
                label: 'Instituição',
                data: Object.values(grafInstituicao.data),
                backgroundColor: grafInstituicao.colors,
                borderColor: grafInstituicao.colors,
                borderWidth: 1,
                datalabels: {
                    color: 'black',
                    anchor: 'end',
                    align: 'top'
                }
            }
            ]
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
                    text: 'Instituição Candidatos Evadidos'
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

    grafEstadoCivil = JSON.parse(grafEstadoCivil.replace(/&quot;/g, '"'));;
    var ctx = document.getElementById('estadocivil').getContext('2d');
    var myChart1 = new Chart(ctx, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
            labels: Object.keys(grafEstadoCivil.data),
            datasets: [{
                label: 'estado civil',
                data: Object.values(grafEstadoCivil.data),
                backgroundColor: grafEstadoCivil.colors,
                borderColor: grafEstadoCivil.colors,
                borderWidth: 1,
                datalabels: {
                    color: 'black',
                    anchor: 'end',
                    align: 'top'
                }
            }
            ]
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
                    text: 'Estado civil dos evadidos'
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

    sexo = JSON.parse(sexo.replace(/&quot;/g, '"'));
    var ctx = document.getElementById('sexo').getContext('2d');
    var myChart1 = new Chart(ctx, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
            labels: Object.keys(sexo.data),
            datasets: [{
                label: 'Sexo',
                data: Object.values(sexo.data),
                backgroundColor: sexo.colors,
                borderColor: sexo.colors,
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
                    text: 'Sexo dos evadidos'
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

    grafidade = JSON.parse(grafidade.replace(/&quot;/g, '"'));
    var ctx = document.getElementById('idade').getContext('2d');
    var myChart1 = new Chart(ctx, {
        plugins: [ChartDataLabels],
        type: 'bar',
        data: {
            labels: Object.keys(grafidade.data),
            datasets: [{
                label: 'idade',
                data: Object.values(grafidade.data),
                backgroundColor: grafidade.colors,
                borderColor: grafidade.colors,
                borderWidth: 1,
                datalabels: {
                    color: 'black',
                    anchor: 'end',
                    align: 'end'
                }
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: Object.keys(grafidade.data).length <= 5 ? 'x' : 'y',
            plugins: {
                title: {
                    display: true,
                    text: 'Idade dos evadidos'
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
        },
    });



    uf = JSON.parse(uf.replace(/&quot;/g, '"'));;
    var ctx = document.getElementById('uf').getContext('2d');
    var myChart1 = new Chart(ctx, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
            labels: Object.keys(uf.data),
            datasets: [{
                label: 'Estado Aluno',
                data: Object.values(uf.data),
                backgroundColor: uf.colors,
                borderColor: uf.colors,
                borderWidth: 1,
                datalabels: {
                    color: 'black',
                    anchor: 'end',
                    align: 'end'
                }
            }
            ]
        },
        options: {
            indexAxis: Object.keys(grafidade.data).length <= 5 ? 'x' : 'y',
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: "Estado dos alunos evadidos"
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


    cancelamentoTurma = JSON.parse(cancelamentoTurma.replace(/&quot;/g, '"'));;
    var ctx = document.getElementById('turma').getContext('2d');
    var myChart1 = new Chart(ctx, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
            labels: Object.keys(cancelamentoTurma.data),
            datasets: [{
                label: 'Turma',
                data: Object.values(cancelamentoTurma.data),
                backgroundColor: cancelamentoTurma.colors,
                borderColor: cancelamentoTurma.colors,
                borderWidth: 1,
                datalabels: {
                    color: 'black',
                    anchor: 'end',
                    align: 'end'
                }
            }
            ]
        },
        options: {
            indexAxis: Object.keys(grafidade.data).length <= 5 ? 'x' : 'y',
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Turma'
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

    campanha = JSON.parse(campanha.replace(/&quot;/g, '"'));
    var ctx = document.getElementById('campanha_').getContext('2d');
    var myChart1 = new Chart(ctx, {
        type: 'bar',
        plugins: [ChartDataLabels],
        data: {
            labels: Object.keys(campanha.data),
            datasets: [{
                label: 'Campanha',
                data: Object.values(campanha.data),
                backgroundColor: campanha.colors,
                borderColor: campanha.colors,
                borderWidth: 1,
                datalabels: {
                    color: 'black',
                    anchor: 'end',
                    align: 'top'
                }
            }
            ]
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
                    text: 'Campanha'
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



    // var ctx = document.getElementById('matVSevad').getContext('2d');
    // var myChart = new Chart(ctx, {
    //     type: 'pie',
    //     plugins: [ChartDataLabels],
    //     data: {
    //         datasets: [{
    //             label: 'My First Dataset',
    //             data: [matriculas, evadidos],
    //             backgroundColor: [
    //                 'rgb(255, 99, 132)',
    //                 'rgb(54, 162, 235)',
    //             ],
    //             hoverOffset: 4
    //         }],
    //         labels: [
    //             'Matriculados',
    //             'Evadidos'
    //         ],
    //     },
    //     options: {
    //         plugins: {
    //             datalabels: {
    //                 formatter: (value, ctx) => {
    //                     let sum = 0;
    //                     let dataArr = ctx.chart.data.datasets[0].data;
    //                     dataArr.map(data => {
    //                         sum += data;
    //                     });
    //                     let percentage = (value * 100 / sum).toFixed(2) + "%";
    //                     return percentage;
    //                 },
    //                 color: '#000',
    //             }
    //         }
    //     }

    // });

    // grafModalidade = JSON.parse(grafModalidade.replace(/&quot;/g, '"'));
    // var ctx = document.getElementById('modalidade').getContext('2d');
    // var myChart1 = new Chart(ctx, {
    //     type: 'bar',
    //     plugins: [ChartDataLabels],
    //     data: {
    //         labels: Object.keys(grafModalidade.modalidade),
    //         datasets: [{
    //             label: 'Modalidade| 1-Presencial, 2-EAD, 3-Semipresencial',
    //             data: Object.values(grafModalidade.modalidade),
    //             backgroundColor: grafModalidade.colors,
    //             borderColor: grafModalidade.colors,
    //             borderWidth: 1,
    //             datalabels: {
    //                 color: 'black',
    //                 anchor: 'end',
    //                 align: 'top'
    //             }
    //         }
    //         ]
    //     },
    //     options: {
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         },
    //         plugins: {
    //             title: {
    //                 display: true,
    //                 text: 'Modalidade'
    //             },
    //             datalabels: {
    //                 formatter: (value, ctx) => {
    //                     let sum = 0;
    //                     let dataArr = ctx.chart.data.datasets[0].data;
    //                     dataArr.map(data => {
    //                         sum += data;
    //                     });
    //                     let percentage = (value * 100 / sum).toFixed(2) + "%";
    //                     return percentage;
    //                 },

    //                 color: '#000',
    //             },
    //             legend: {
    //                 display: false
    //             },
    //             tooltips: {
    //                 callbacks: {
    //                     label: function (tooltipItem) {
    //                         return tooltipItem.yLabel;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // });
}