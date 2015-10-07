var options = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero: true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines: true,
    //String - Colour of the grid lines
    scaleGridLineColor: "rgba(0,0,0,0.05)",
    //Number - Width of the grid lines
    scaleGridLineWidth: 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines: false,
    //Boolean - If there is a stroke on each bar
    barShowStroke: false,
    //Number - Pixel width of the bar stroke
    barStrokeWidth: 0,
    //Number - Spacing between each of the X value sets
    barValueSpacing: 10,
    //Number - Spacing between data sets within X values
    barDatasetSpacing: 0,
    // Boolean - whether or not the chart should be responsive and resize when the browser does.
    responsive: true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive,
    // if set to false, will take up entire container
    maintainAspectRatio: true,
    
    animation: false,
}


function createChart(databaseName,data){
    // Get context with jQuery - using jQuery's .get() method.x
    var ctx = $('#' + databaseName).get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var myBarChart = new Chart(ctx).Bar(data, options);

};