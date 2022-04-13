// $(document).ready(function () {
//     $('table').each(function () {
//         var $table = $(this);

//         var $button = $("<button type='button' class='mt-2 mb-2 btn btn-primary'>");
//         $button.text("Exportar para CSV");
//         $button.insertBefore($table);

//         $button.click(function () {
//             var csv = $table.table2CSV({
//                 delivery: 'value'
//             });
//             window.location.href = 'data:text/csv;charset=UTF-8,' +
//                 encodeURIComponent(csv);
//         });
//     });
// });

window.onload = function () {
        $('#totalBolGerados').html(totalBolGerados);
        $('#totalBolAtivos').html(totalBolAtivos);
        $('#totalBolCancelados').html(totalBolCancelados);
        $('#totalBolCancNegociacao').html(totalBolCancNegociacao);
        $('#totalBolPagosMensalidades').html(totalBolPagosMensalidades);
        $('#totalBolPagosNegociacoes').html(totalBolPagosNegociacoes);
        $('#totalBolEmAberto').html(totalBolEmAberto);
        $('#totalBolAtrasados').html(totalBolAtrasados);

        $('#totalNegBoletos').html(totalNegBoletos);
        $('#totalNegBoletosAtivos').html(totalNegBoletosAtivos);
        $('#totalNegCancelados').html(totalNegCancelados);
        $('#totalNegNegociados').html(totalNegNegociados);
        $('#totalNegPagos').html(totalNegPagos);
        $('#totalNegAbertos').html(totalNegAbertos);
        $('#totalNegAtrasados').html(totalNegAtrasados);

        $("#adimplentes").html(adimplentes);
        $("#inadimplentes").html(inadimplentes);
        $("#cancelados").html(cancelados);

    // statusFatura = JSON.parse(statusFatura.replace(/&quot;/g, '"'));
    // var ctx = document.getElementById('statusFatura').getContext('2d');
    // var myChart1 = new Chart(ctx, {
    //     type: 'bar',
    //     plugins: [ChartDataLabels],
    //     data: {
    //         labels: Object.keys(statusFatura.data),
    //         datasets: [{
    //             label: 'Instituição',
    //             data: Object.values(statusFatura.data),
    //             backgroundColor: statusFatura.colors,
    //             borderColor: statusFatura.colors,
    //             borderWidth: 1,
    //             datalabels: {
    //                 color: 'black',
    //                 anchor: 'end',
    //                 align: 'top'
    //             }
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
    //                 text: 'Status Fatura'
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
};