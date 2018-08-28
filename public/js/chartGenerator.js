// Chart.pluginService.register({
//     beforeRender: function (chart) {
//         if (chart.config.options.showAllTooltips) {
//             // create an array of tooltips
//             // we can't use the chart tooltip because there is only one tooltip per chart
//             chart.pluginTooltips = [];
//             chart.config.data.datasets.forEach(function (dataset, i) {
//                 chart.getDatasetMeta(i).data.forEach(function (sector, j) {
//                     chart.pluginTooltips.push(new Chart.Tooltip({
//                         _chart: chart.chart,
//                         _chartInstance: chart,
//                         _data: chart.data,
//                         _options: chart.options.tooltips,
//                         _active: [sector]
//                     }, chart));
//                 });
//             });

//             //turn off normal tooltips
//             chart.options.tooltips.enabled = false;
//         }
//     },
//     afterDraw: function (chart, easing) {
//         if (chart.config.options.showAllTooltips) {
//            // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
//             if (!chart.allTooltipsOnce) {
//                 if (easing !== 1)
//                     return;
//                 chart.allTooltipsOnce = true;
//             }

//             // turn on tooltips
//             chart.options.tooltips.enabled = true;
//             Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
//                 tooltip.initialize();
//                 tooltip.update();
//                 //we don't actually need this since we are not animating tooltips
//                 tooltip.pivot();
//                 tooltip.transition(easing).draw();
//             });
//             chart.options.tooltips.enabled = false;
//         }
//     }
// });


// $(function () {
//     /* INICIO: crea las variables para los datos de los graficos, con los datos de las vistas. */
//     var datos = {
//         labels: [],
//         datasets:
//             [{
//                 label: 'Etiqueta',
//                 data: [],
//                 lineTension: 0,
//                 fill: false,
//                 borderColor:  'rgba(0,192,239)', //Color de la linea del grafico
//                 backgroundColor: 'transparent', //Color de fondo de la etiqueta que describe la linea
//                 borderDash: [1, 0], //Linea continua, primer valor la cantidad de pixeles, segundo valor la separacion entre uno y otro
//                 pointBorderColor: 'rgba(0,115,183)', //Color del bordeado del punto
//                 pointBackgroundColor: 'rgba(0,115,183)', //Color del punto
//                 pointRadius: 3, //Punto en el grafico, que tan ancho sera
//                 pointHoverRadius: 5, //Ancho del punto en el grafico al pasar el mouse
//                 pointHitRadius: 30,
//                 pointBorderWidth: 2,
//                 pointStyle: 'circle'
//             }]

//     };
//     /* FIN: se cargan los graficos con los datos de las vistas */

//     // INICIO: se obtienen los contextos de la vista, para dibujar los graficos.
//     // Para el grafico de lineas para la variable de Temperaturas
//     if ($("#grafico").length > 0) {
//         var ctx_garfico = document.getElementById("grafico").getContext("2d");
//     }
//     // FIN: se obtienen los contextos de las vistas


//     //INICIO: se crean los graficos y se dibujan en la vista
//     grafico = new Chart(ctx_grafico, {
//         type: 'line',
//         data: datos,
//         options: {
//             title: {
//                 display: true,
//                 text: 'Valores',
//                 position: 'bottom'
//             },
//         }
//     });
//     //FIN: creación de los gráficos

//     // INICIO: grafico de barras
//     var datosBarras = {
//         labels: [], //Etiquetas de la parte de abajo del grafico
//         datasets: [{
//             label: "Etiqueta", //Etiqueta que se muestra al pasar el mouse sobre la barra del grafico
//             data: [], //Datos a cargar en la barra del grafico
//             backGroundColor: 'black', //Color de fondo de la barra del grafico
//             borderColor: 'black', //Color de borde de la barra del grafico
//             borderWidth: 1 //Ancho del borde de la barra
//         }]
//     };

//     var ctxGraficoBarras = document.getElementById("graficoBarras").getContext("2d");

//     var chartOptions = {
//         responsive: true,
//         title: {
//             display: true,
//             fontSize: 18,
//             fontColor: "#111"
//         },
//         legend: {
//             display: true,
//             position: "top",
//             labels: {
//                 fontColor: "#333",
//                 fontSize: 16
//             }
//         },
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     min: 0
//                 }
//             }]
//         }
//     };

//     graficoTotales = new Chart(ctxGraficoBarras, {
//         type: 'bar',
//         data: datosBarras,
//         options: chartOptions
//     });
// });

function generarGraficoDeLineas(etiquetas, titulo, datos, idGrafico) {
    var datosGrafico = {
        labels: etiquetas,
        datasets:
            [{
                label: titulo,
                data: datos,
                lineTension: 0,
                fill: false,
                borderColor:  'rgba(0,192,239)', //Color de la linea del grafico
                backgroundColor: 'transparent', //Color de fondo de la etiqueta que describe la linea
                borderDash: [1, 0], //Linea continua, primer valor la cantidad de pixeles, segundo valor la separacion entre uno y otro
                pointBorderColor: 'rgba(0,115,183)', //Color del bordeado del punto
                pointBackgroundColor: 'rgba(0,115,183)', //Color del punto
                pointRadius: 3, //Punto en el grafico, que tan ancho sera
                pointHoverRadius: 5, //Ancho del punto en el grafico al pasar el mouse
                pointHitRadius: 30,
                pointBorderWidth: 2,
                pointStyle: 'circle'
            }]

    };
    /* FIN: se cargan los graficos con los datos de las vistas */

    // INICIO: se obtienen los contextos de la vista, para dibujar los graficos.
    // Para el grafico de lineas para la variable de Temperaturas
    var ctx_grafico = document.getElementById(idGrafico).getContext("2d");
    // FIN: se obtienen los contextos de las vistas


    //INICIO: se crean los graficos y se dibujan en la vista
    grafico = new Chart(ctx_grafico, {
        type: 'line',
        data: datosGrafico,
        options: {
            title: {
                display: true,
                text: 'Valores',
                position: 'bottom'
            },
        }
    });
    //FIN: creación de los gráficos
}

function generarGraficoBarras(etiquetas, titulo, datos, idGrafico) {
    // INICIO: grafico de barras
    var datosGrafico = {
        labels: etiquetas, //Etiquetas de la parte de abajo del grafico
        datasets: [{
            label: titulo, //Etiqueta que se muestra al pasar el mouse sobre la barra del grafico
            data: datos, //Datos a cargar en la barra del grafico
            backGroundColor: 'black', //Color de fondo de la barra del grafico
            borderColor: 'black', //Color de borde de la barra del grafico
            borderWidth: 1 //Ancho del borde de la barra
        }]
    };

    var ctxGrafico = document.getElementById(idGrafico).getContext("2d");

    var chartOptions = {
        responsive: true,
        title: {
            display: true,
            fontSize: 18,
            fontColor: "#111"
        },
        legend: {
            display: true,
            position: "top",
            labels: {
                fontColor: "#333",
                fontSize: 16
            }
        },
        scales: {
            yAxes: [{
                ticks: {
                    min: 0
                }
            }]
        }
    };

    grafico = new Chart(ctxGrafico, {
        type: 'bar',
        data: datosGrafico,
        options: chartOptions
    });
}

function generarGraficoPie(idGrafico, datos) {
    ctxGrafico = $('#'+idGrafico).get(0).getContext("2d");

    graficoPie = new Chart(ctxGrafico);

    dataPie = [
        {
            value: 700,
            color: '#f56954',
            highlight: '#f56954',
            label: 'Ejemplo #1' 
        },
        {
            value: 500,
            color: '#00a65a',
            highlight: '#00a65a',
            label: 'Ejemplo #2' 
        },
        {
            value: 90,
            color: '#f39c12',
            highlight: '#f39c12',
            label: 'Ejemplo #3' 
        },
        {
            value: 120,
            color: '#00c0ef',
            highlight: '#00c0ef',
            label: 'Ejemplo #4' 
        }
    ];

    optionsPie = {
        //Boolean - Whether we should show a stroke on each segment
        segmentShowStroke    : true,
        //String - The colour of each segment stroke
        segmentStrokeColor   : '#fff',
        //Number - The width of each segment stroke
        segmentStrokeWidth   : 2,
        //Number - The percentage of the chart that we cut out of the middle
        percentageInnerCutout: 50, // This is 0 for Pie charts
        //Number - Amount of animation steps
        animationSteps       : 100,
        //String - Animation easing effect
        animationEasing      : 'easeOutBounce',
        //Boolean - Whether we animate the rotation of the Doughnut
        animateRotate        : true,
        //Boolean - Whether we animate scaling the Doughnut from the centre
        animateScale         : false,
        //Boolean - whether to make the chart responsive to window resizing
        responsive           : true,
        // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio  : true,
        //String - A legend template
        legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    };

    graficoPie.Doughnut(dataPie, optionsPie);
}

function lineas(idGrafico, etiquetas, titulo, datos) {
    var contextoGrafico = $('#'+idGrafico).get(0).getContext('2d');

    var grafico = new Chart(contextoGrafico);
    var opcionesGrafico = {
        //Boolean - If we should show the scale at all
        showScale               : true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines      : false,
        //String - Colour of the grid lines
        scaleGridLineColor      : 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth      : 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines  : true,
        //Boolean - Whether the line is curved between points
        bezierCurve             : true,
        //Number - Tension of the bezier curve between points
        bezierCurveTension      : 0.3,
        //Boolean - Whether to show a dot for each point
        pointDot                : false,
        //Number - Radius of each point dot in pixels
        pointDotRadius          : 4,
        //Number - Pixel width of point dot stroke
        pointDotStrokeWidth     : 1,
        //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
        pointHitDetectionRadius : 20,
        //Boolean - Whether to show a stroke for datasets
        datasetStroke           : true,
        //Number - Pixel width of dataset stroke
        datasetStrokeWidth      : 2,
        //Boolean - Whether to fill the dataset with a color
        datasetFill             : true,
        //String - A legend template
        legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
        maintainAspectRatio     : true,
        //Boolean - whether to make the chart responsive to window resizing
        responsive              : true
    };

    opcionesGrafico.datasetFill = false;

    datosGrafico = {
        labels: etiquetas,
        datasets: [
            {
                label               : 'Electronics',
                fillColor           : 'rgba(210, 214, 222, 1)',
                strokeColor         : 'rgba(210, 214, 222, 1)',
                pointColor          : 'rgba(210, 214, 222, 1)',
                pointStrokeColor    : '#c1c7d1',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data                : [65, 59, 80, 81, 56, 55, 40]
            },
            {
                label               : 'Digital Goods',
                fillColor           : 'rgba(60,141,188,0.9)',
                strokeColor         : 'rgba(60,141,188,0.8)',
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : [28, 48, 40, 19, 86, 27, 90]
            }
        ]
    };

    grafico.Line(datosGrafico, opcionesGrafico);
}

function barras(idGrafico, etiquetas, titulo, datos) {
    var contextoGrafico = $('#'+idGrafico).get(0).getContext('2d');

    graficoBarras = new Chart(contextoGrafico);

    datosGrafico = {
        labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
            {
                label               : 'Electronics',
                fillColor           : 'rgba(210, 214, 222, 1)',
                strokeColor         : 'rgba(210, 214, 222, 1)',
                pointColor          : 'rgba(210, 214, 222, 1)',
                pointStrokeColor    : '#c1c7d1',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(220,220,220,1)',
                data                : [65, 59, 80, 81, 56, 55, 40]
            },
            {
                label               : 'Digital Goods',
                fillColor           : '#00a65a',
                strokeColor         : '#00a65a',
                pointColor          : '#00a65a',
                pointStrokeColor    : 'rgba(60,141,188,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(60,141,188,1)',
                data                : [28, 48, 40, 19, 86, 27, 90]
            }
        ]
    };

    opcionesGrafico = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero        : true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines      : true,
        //String - Colour of the grid lines
        scaleGridLineColor      : 'rgba(0,0,0,.05)',
        //Number - Width of the grid lines
        scaleGridLineWidth      : 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines  : true,
        //Boolean - If there is a stroke on each bar
        barShowStroke           : true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth          : 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing         : 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing       : 1,
        //String - A legend template
        legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
        //Boolean - whether to make the chart responsive
        responsive              : true,
        maintainAspectRatio     : true,
        datasetFill: false
    };

    graficoBarras.Bar(datosGrafico, opcionesGrafico);
}