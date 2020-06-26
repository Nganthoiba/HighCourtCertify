/**** Javascript functions to draw charts ****/

//draw barchart
function drawBarChart(layout_id,barChartInfo){
    /*layout_id: the canvas id where the barchart will be drawn */
    /*
     * {
                labels: ["January", "February", "March", "April", "May", "June", "July"],
                datasets: [{
                    label: '# of Applications',
                    backgroundColor: "#26B99A",
                    data: [51, 30, 40, 28, 92, 50, 45]
                }, 
                {
                    label: '# of Completed Applications',
                    backgroundColor: "#03586A",
                    data: [41, 56, 25, 48, 72, 34, 12]
                }]
            }
     */
    if ($('#'+layout_id).length ){
        var ctx = document.getElementById(layout_id);
        var mybarChart = new Chart(ctx, {
            type: 'bar',
            data: barChartInfo,

            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }
}

