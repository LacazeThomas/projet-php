<script type='text/javascript'>
<?php
$count_array_line = $_SESSION["graph_count_line"];
$matiere_array_line = $_SESSION["graph_matiere_line"];
$graph_ec_line = $_SESSION["graph_ec_line"];

unset($_SESSION["graph_matiere_line"]);
unset($_SESSION["graph_count_line"]);
unset($_SESSION["graph_ec_line"]);

$js_count_array_line = json_encode($count_array_line);
$js_matiere_array_line = json_encode($matiere_array_line);
$js_graph_ec_line = json_encode($graph_ec_line);

echo "var javascript_count_array_line = " . $js_count_array_line . ";\n";
echo "var javascript_matiere_array_line = " . $js_matiere_array_line . ";\n";
echo "var javascript_graph_ec_line = " . $js_graph_ec_line . ";\n";
?>
</script>

<script src="/g9/assets/graph/graph.js"></script>

<div class="col-md-12">
        <p>Moyenne</p>
        <canvas id="myChart_line"></canvas>
</div>

<script>
var ctx = document.getElementById("myChart_line").getContext('2d');
var myChart = new Chart(ctx, {

    type: 'bar',
    responsive: true,
    data: {
        labels: javascript_matiere_array_line,
        datasets: [{
        data: javascript_count_array_line,
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
        label: "Moyenne",
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
                        id: 'y-axis-1',
                        display: true,
                        position: 'left',

                         ticks: {
                            beginAtZero: true,
                            min : 0,
                            max: 5,


                             callback: function(value, index, values) {
                                if (value == 5)
                                    return "Très mécontent";
                                else if (value == 4)
                                    return "Mécontent";
                                else if (value == 3)
                                    return "Moyen";
                                else if (value == 1)
                                    return "Satisfait";
                                else if (value == 0)
                                    return "Très satisfait";                                
                            }
                        }, 
                    }
                ]
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
