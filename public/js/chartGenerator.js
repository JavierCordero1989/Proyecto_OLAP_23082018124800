Chart.pluginService.register({
    beforeRender: function (chart) {
        if (chart.config.options.showAllTooltips) {
            // create an array of tooltips
            // we can't use the chart tooltip because there is only one tooltip per chart
            chart.pluginTooltips = [];
            chart.config.data.datasets.forEach(function (dataset, i) {
                chart.getDatasetMeta(i).data.forEach(function (sector, j) {
                    chart.pluginTooltips.push(new Chart.Tooltip({
                        _chart: chart.chart,
                        _chartInstance: chart,
                        _data: chart.data,
                        _options: chart.options.tooltips,
                        _active: [sector]
                    }, chart));
                });
            });

            //turn off normal tooltips
            chart.options.tooltips.enabled = false;
        }
    },
    afterDraw: function (chart, easing) {
        if (chart.config.options.showAllTooltips) {
           // we don't want the permanent tooltips to animate, so don't do anything till the animation runs atleast once
            if (!chart.allTooltipsOnce) {
                if (easing !== 1)
                    return;
                chart.allTooltipsOnce = true;
            }

            // turn on tooltips
            chart.options.tooltips.enabled = true;
            Chart.helpers.each(chart.pluginTooltips, function (tooltip) {
                tooltip.initialize();
                tooltip.update();
                //we don't actually need this since we are not animating tooltips
                tooltip.pivot();
                tooltip.transition(easing).draw();
            });
            chart.options.tooltips.enabled = false;
        }
    }
});


function graficoDePie(id_del_grafico) {
    var datosGrafico = {
        labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
        datasets: [{
            label: "Population (millions)",
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
            data: [2478,5267,734,784,433]
        }]
    };
    /* FIN: se cargan los graficos con los datos de las vistas */

    // INICIO: se obtienen los contextos de la vista, para dibujar los graficos.
    // Para el grafico de lineas para la variable de Temperaturas
    var ctx_grafico = document.getElementById(id_del_grafico).getContext("2d");
    // FIN: se obtienen los contextos de las vistas


    //INICIO: se crean los graficos y se dibujan en la vista
    grafico = new Chart(ctx_grafico, {
        type: 'pie',
        data: datosGrafico,
        options: {
            title: {
                display: true,
                text: 'Predicted world population (millions) in 2050'
            }
        }
    });
    //FIN: creación de los gráficos
}

function graficoDeBarras(id_del_grafico) {
    var datosGrafico = {
        labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
        datasets: [{
            label: "Population (millions)",
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
            data: [2478,5267,734,784,433]
        }]
    };
    /* FIN: se cargan los graficos con los datos de las vistas */

    // INICIO: se obtienen los contextos de la vista, para dibujar los graficos.
    // Para el grafico de lineas para la variable de Temperaturas
    var ctx_grafico = document.getElementById(id_del_grafico).getContext("2d");
    // FIN: se obtienen los contextos de las vistas


    //INICIO: se crean los graficos y se dibujan en la vista
    grafico = new Chart(ctx_grafico, {
        type: 'bar',
        data: datosGrafico,
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Predicted world population (millions) in 2050'
            }
        }
    });
    //FIN: creación de los gráficos
}

function graficoDeLineas(id_del_grafico) {
    var datosGrafico = {
        labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
        datasets: [
            { 
                data: [86,114,106,106,107,111,133,221,783,2478],
                label: "Africa",
                borderColor: "#3e95cd",
                fill: false
            }, { 
                data: [282,350,411,502,635,809,947,1402,3700,5267],
                label: "Asia",
                borderColor: "#8e5ea2",
                fill: false
            }, { 
                data: [168,170,178,190,203,276,408,547,675,734],
                label: "Europe",
                borderColor: "#3cba9f",
                fill: false
            }, { 
                data: [40,20,10,16,24,38,74,167,508,784],
                label: "Latin America",
                borderColor: "#e8c3b9",
                fill: false
            }, { 
                data: [6,3,2,2,7,26,82,172,312,433],
                label: "North America",
                borderColor: "#c45850",
                fill: false
            }
        ]
    };
    /* FIN: se cargan los graficos con los datos de las vistas */

    // INICIO: se obtienen los contextos de la vista, para dibujar los graficos.
    // Para el grafico de lineas para la variable de Temperaturas
    var ctx_grafico = document.getElementById(id_del_grafico).getContext("2d");
    // FIN: se obtienen los contextos de las vistas


    //INICIO: se crean los graficos y se dibujan en la vista
    grafico = new Chart(ctx_grafico, {
        type: 'line',
        data: datosGrafico,
        options: {
            title: {
                display: true,
                text: 'World population per region (in millions)'
            }
        }
    });
    //FIN: creación de los gráficos
}

function graficoDeDona(id_del_grafico) {
    var datosGrafico = {
        labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
        datasets: [
            {
                label: "Population (millions)",
                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                data: [2478,5267,734,784,433]
            }
        ]
    };
    /* FIN: se cargan los graficos con los datos de las vistas */

    // INICIO: se obtienen los contextos de la vista, para dibujar los graficos.
    // Para el grafico de lineas para la variable de Temperaturas
    var ctx_grafico = document.getElementById(id_del_grafico).getContext("2d");
    // FIN: se obtienen los contextos de las vistas


    //INICIO: se crean los graficos y se dibujan en la vista
    grafico = new Chart(ctx_grafico, {
        type: 'doughnut',
        data: datosGrafico,
        options: {
            title: {
                display: true,
                text: 'Predicted world population (millions) in 2050'
            }
        }
    });
    //FIN: creación de los gráficos
}

function graficoDeBarrasHorizontales(id_del_grafico) {
    var datosGrafico = {
        labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
        datasets: [
            {
                label: "Population (millions)",
                backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
                data: [2478,5267,734,784,433]
            }
        ]
    };
    /* FIN: se cargan los graficos con los datos de las vistas */

    // INICIO: se obtienen los contextos de la vista, para dibujar los graficos.
    // Para el grafico de lineas para la variable de Temperaturas
    var ctx_grafico = document.getElementById(id_del_grafico).getContext("2d");
    // FIN: se obtienen los contextos de las vistas


    //INICIO: se crean los graficos y se dibujan en la vista
    grafico = new Chart(ctx_grafico, {
        type: 'horizontalBar',
        data: datosGrafico,
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Predicted world population (millions) in 2050'
            }
        }
    });
    //FIN: creación de los gráficos
}

function graficoDeBarrasAgrupadas(id_del_grafico) {
    var datosGrafico = {
        labels: ["1900", "1950", "1999", "2050"],
        datasets: [
            {
                label: "Africa",
                backgroundColor: "#3e95cd",
                data: [133,221,783,2478]
            }, {
                label: "Europe",
                backgroundColor: "#8e5ea2",
                data: [408,547,675,734]
            }
        ]
    };
    /* FIN: se cargan los graficos con los datos de las vistas */

    // INICIO: se obtienen los contextos de la vista, para dibujar los graficos.
    // Para el grafico de lineas para la variable de Temperaturas
    var ctx_grafico = document.getElementById(id_del_grafico).getContext("2d");
    // FIN: se obtienen los contextos de las vistas


    //INICIO: se crean los graficos y se dibujan en la vista
    grafico = new Chart(ctx_grafico, {
        type: 'bar',
        data: datosGrafico,
        options: {
            title: {
                display: true,
                text: 'Population growth (millions)'
            }
        }
    });
    //FIN: creación de los gráficos
}