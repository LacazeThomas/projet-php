<?php
if (!isset($_SESSION["graph_count_line"]) or !isset($_SESSION["graph_matiere_line"])) {
    header('Location: ../');
}
?>

<script src="/assets/graph/graph.js"></script>


<div class="col-md-12">
        <canvas id="myChart_line_ec" style="height:20vh;width:35vw"></canvas>
</div>

<script>
var ctx = document.getElementById("myChart_line_ec").getContext('2d');
var myChart = new Chart(ctx, {

    type: 'line',
    responsive: true,
    data: {
        labels: javascript_matiere_array_line,
        datasets: [{
        data: javascript_graph_ec_line,
        label: "Ecart-type",
        borderColor: "#3e95cd",
        fill: false
      }]
    },
    options: {

    legend: {
        display: true

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
