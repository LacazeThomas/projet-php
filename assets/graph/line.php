<?php
if (!isset($_SESSION["graph_count_line"]) or !isset($_SESSION["graph_matiere_line"])) {
    header('Location: ../');
}
?>

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

<script src="/assets/graph/graph.js"></script>

<div class="chartjs-size-monitor-shrink" style="height:20vh;width:35vw">

<canvas id="myChart_line"  ></canvas>
</div>


<script>
var ctx = document.getElementById("myChart_line").getContext('2d');
var myChart = new Chart(ctx, {

    type: 'line',
    responsive: true,
    data: {
        labels: javascript_matiere_array_line,
        datasets: [{
        data: javascript_count_array_line,
        label: "Moyenne",
        borderColor: "rgba(255, 159, 64, 1)",
        fill: false
      }]
    },
    options: {

    legend: {
        display: true

    },
    scales: {
                yAxes: [
                    {
                        id: 'y-axis-1',
                        display: true,
                        position: 'left',

                         ticks: {
                            beginAtZero: true,
                            max: 5,

                             callback: function(value, index, values) {
                                if (value == 1)
                                    return "Très mécontent";
                                else if (value == 2)
                                    return "Mécontent";
                                else if (value ==3)
                                    return "Moyen";
                                else if (value ==4)
                                    return "Satisfait";
                                else if (value ==5)
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
