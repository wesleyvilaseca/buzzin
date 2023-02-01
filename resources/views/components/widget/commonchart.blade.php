{{-- para utilizar esse component, é necessário utilizar a lib charjs --}}

<canvas id="{{ @$name }}" width="200" height="{{ @$heigth ? @$heigth : 200 }}"></canvas>

{{-- @section('components-js') --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script>
    var grafobj = "{{ @$grafobj }}";
    var graftitle = "{{ @$title }}";
    var charid = "{{ @$name }}";
    var displayLegend = "{{ @$displayLegend }}";
    var positionLegend = "{{ @$positionLegend }}";
    var subtitle = "{{ @$subtitle }}";
    var grafType = "{{ @$grafType ?? 'bar' }}";

    var optionsLegend = {};
    optionsLegend.display = displayLegend ? displayLegend : false;
    if (displayLegend) optionsLegend.position = positionLegend;

    var dataSets = [];
    grafobj = JSON.parse(grafobj.replace(/&quot;/g, '"'));

    var ctx = document.getElementById(charid).getContext('2d');
    var myChart1 = new Chart(ctx, {
        plugins: [ChartDataLabels],
        type: grafType,
        data: {
            labels: Object.keys(grafobj.data),
            datasets: [{
                label: Object.keys(grafobj.data),
                data: Object.values(grafobj.data),
                backgroundColor: grafobj.colors,
                borderColor: grafobj.colors,
                borderWidth: 1,
                datalabels: {
                    color: 'black',
                    anchor: 'end',
                    align: 'end'
                }
            }]
        },
        options: {
            // responsive: false,
            // maintainAspectRatio: false,
            indexAxis: Object.keys(grafobj.data).length <= 5 ? 'x' : 'y',
            plugins: {
                title: {
                    display: true,
                    text: graftitle
                },
                subtitle: {
                    display: subtitle ?? false,
                    text: subtitle
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
                legend: optionsLegend,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.yLabel;
                        }
                    }
                }
            }
        }
    });
</script>
{{-- @endsection --}}
