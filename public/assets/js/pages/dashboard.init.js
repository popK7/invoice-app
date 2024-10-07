/*
Template Name: Invoika - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Analytics sales init js
*/

// get colors array from the string
function getChartColorsArray(chartId) {
    if (document.getElementById(chartId) !== null) {
        var colors = document.getElementById(chartId).getAttribute("data-colors");
        if (colors) {
            colors = JSON.parse(colors);
            return colors.map(function (value) {
                var newValue = value.replace(" ", "");
                if (newValue.indexOf(",") === -1) {
                    var color = getComputedStyle(document.documentElement).getPropertyValue(newValue);
                    if (color) return color;
                    else return newValue;
                } else {
                    var val = value.split(',');
                    if (val.length == 2) {
                        var rgbaColor = getComputedStyle(document.documentElement).getPropertyValue(val[0]);
                        rgbaColor = "rgba(" + rgbaColor + "," + val[1] + ")";
                        return rgbaColor;
                    } else {
                        return newValue;
                    }
                }
            });
        } else {
            console.warn('data-colors atributes not found on', chartId);
        }
    }
}

// mini-1
var vectorMapWorldLineColors = getChartColorsArray("mini-chart1");
if (vectorMapWorldLineColors) {
    var options = {
        series: [60, 40],
        chart: {
            type: 'donut',
            height: 110,
        },
        colors: vectorMapWorldLineColors,
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        }
    };

    var chart = new ApexCharts(document.querySelector("#mini-chart1"), options);
    chart.render();
}


// mini-2
var vectorMapWorldLineColors = getChartColorsArray("mini-chart2");
if (vectorMapWorldLineColors) {
    var options = {
        series: [35, 80],
        chart: {
            type: 'donut',
            height: 110,
        },
        colors: vectorMapWorldLineColors,
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        }
    };

    var chart = new ApexCharts(document.querySelector("#mini-chart2"), options);
    chart.render();
}

// mini-3
var vectorMapWorldLineColors = getChartColorsArray("mini-chart3");
if (vectorMapWorldLineColors) {
    var options = {
        series: [70, 30],
        chart: {
            type: 'donut',
            height: 110,
        },
        colors: vectorMapWorldLineColors,
        legend: {
            show: false
        },
        dataLabels: {
            enabled: false
        }
    };

    var chart = new ApexCharts(document.querySelector("#mini-chart3"), options);
    chart.render();
}


// stacked column chart
function paymentActivityChart(paidArray,unpaidArray) {
    
    var isLastSixMonth = paidArray.length;
    if(isLastSixMonth == 7 || isLastSixMonth == 6) {
        var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        var today = new Date();
        var d;
        var month;
        var months = [];

        for(var i = isLastSixMonth; i > 0; i -= 1) {
            d = new Date(today.getFullYear(), today.getMonth() - i, 1);
            month = monthNames[d.getMonth()];
            months.push(month);
        }
    } else if(isLastSixMonth > 12) {

        var today = new Date();
        let year = today.getFullYear();
        let month = today.getMonth()+1;
        --month
        let date = new Date(year, month)
        var months = []
        while(date.getMonth()==month){
            months.push(`${date.getDate()}`)
            date.setDate(date.getDate()+1)
        }
        
    } else {
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    }

    var linechartBasicColors = getChartColorsArray("stacked-column-chart");
    if (linechartBasicColors) {
        var options = {
            chart: {
                height: 362,
                type: 'bar',
                // stacked: true,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: true
                }
            },

            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '35%',
                    endingShape: 'rounded'
                },
            },

            dataLabels: {
                enabled: false
            },
            series: [{
                name: 'Paid',
                data: paidArray
            }, {
                name: 'Unpaid',
                data: unpaidArray
            }],
            xaxis: {
                categories: months,
            },
            grid:{
                xaxis: {
                    lines: {
                        show: false
                    }
                },   
                yaxis: {
                    lines: {
                        show: false
                    }
                }, 
            },
            colors: linechartBasicColors,
            legend: {
                show: false
            },
            fill: {
                opacity: 1
            },
        }

        var chart = new ApexCharts(
            document.querySelector("#stacked-column-chart"),
            options
        );

        chart.render();
        chart.resetSeries();
    }
}


// Saleing Categories
function structureChart(paidAmount,pendingAmount,cancelledAmount) {
    var barchartColors = getChartColorsArray("structure-widget");
    if (barchartColors) {
        var options = {
        chart: {
            height: 285,
            type: 'donut',
        }, 
        series: [paidAmount, pendingAmount, cancelledAmount],
        labels: ["Paid", "Unpaid", "Cancelled"],
        colors: barchartColors,
        plotOptions: {
            pie: {
                startAngle: 0,
                donut: {
                size: '78%',
                }
            }
        },

        legend: {
            show: false,
        },

        dataLabels: {
                style: {
                fontSize: '11px',
                fontFamily: 'DM Sans,sans-serif',
                colors: undefined
                },
            
                background: {
                enabled: true,
                foreColor: '#fff',
                padding: 4,
                borderRadius: 2,
                borderWidth: 1,
                borderColor: '#fff',
                opacity: 1,
                },
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: false
                },
            }
        }]
        }
        
        var chart = new ApexCharts(
        document.querySelector("#structure-widget"),
        options
        );
        
        chart.render();
        chart.resetSeries();
    }
}



// payment-overview
function overViewChart(paidArray,unpaidArray) {

var barchartColors = getChartColorsArray("payment-overview");
    if (barchartColors) {
        var options1 = {
        chart: {
            type: 'area',
            height: 341,
            toolbar: {
            show: false
            },
        },
        series: [{
            name: 'Paid Amount',
            data: paidArray
        }, {
            name: 'Unpaid Amount',
            data: unpaidArray
        }
        ],
        stroke: {
            curve: 'smooth',
            width: ['3.5', '3.5'],
        },
        grid:{
            xaxis: {
                lines: {
                    show: true
                }
            },   
            yaxis: {
                lines: {
                    show: true
                }
            },
        },
        colors: barchartColors,
        xaxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Now','Des'],
        },
        legend: {
            show: false,
        },

        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                inverseColors: false,
                opacityFrom: 0.40,
                opacityTo: 0.1,
                stops: [30, 100, 100, 100]
                },
            },
            dataLabels: {
            enabled: false
            },
        tooltip: {
            fixed: {
            enabled: false
            }
            ,
            x: {
            show: false
            }
            ,
            y: {
            title: {
                formatter: function (seriesName) {
                return ''
                }
            }
            }
            ,
            marker: {
            show: false
            }
        }
        }
        // new ApexCharts(document.querySelector("#payment-overview"), options1).render();
        // chart.resetSeries();
        chart = new ApexCharts(document.querySelector("#payment-overview"), options1);
        chart.render();
        chart.resetSeries();
    }
}

// world map with markers
function worldMapChart(latLongArray) {
    var worldemapmarkers = new jsVectorMap({
        map: 'world_merc',
        selector: '#world-map-markers',
        zoomOnScroll: false,
        zoomButtons: false,
        selectedMarkers: [0, 2],
        markersSelectable: true,
        regionStyle : {
            initial : {
                fill : '#ddeae7'
            }
        },
        markers:JSON.parse(latLongArray),

        markerStyle:{
        initial: { fill: "#438a7a" },
        selected: { fill: "#438a7a" }
        },
        labels: {
            markers: {
                render: function(marker){
                    return marker.name
                }
            }
        }
    })
}