<?php
if (!isset($_SESSION["graph_count_line"]) or !isset($_SESSION["graph_matiere_line"])) {
    header('Location: ../');
}
?>

<script src="/assets/graph/graph.js"></script>


<div class="col-md-12">
        <p>Ecart-type</p>
        <canvas id="myChart_line_ec"></canvas>
</div>

<script>
var ctx = document.getElementById("myChart_line_ec").getContext('2d');
var myChart = new Chart(ctx, {

    type: 'bar',
    responsive: true,
    data: {
        labels: javascript_matiere_array_line,
        datasets: [{
        data: javascript_graph_ec_line,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1,
        label: "Ecart-type",
        fill: false
      }]
    },
    options: {

    legend: {
        display: false

    },
    scales: {
                yAxes: [
                    {

                         ticks: {
                            beginAtZero: true,
                         }
                    }]
    },

    tooltips: {
        callbacks: {
           label: function(tooltipItem) {
                  return tooltipItem.yLabel;
           }
        }
    }
}
});

</script>
