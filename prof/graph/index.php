<?php


if ($_SESSION["role"] != "prof" or !isset($_SESSION["graph_count"]) or  !isset($_SESSION["graph_matiere"])){
    header('Location: ../');
}
?>

<script type='text/javascript'>
<?php
$count_array = $_SESSION["graph_count"];
$notation_array = $_SESSION["graph_matiere"];
unset($_SESSION["graph_count"]);
unset($_SESSION["graph_matiere"]);
$js_count_array = json_encode($count_array);
$js_notation_array = json_encode($notation_array);
echo "var javascript_count_array = " . $js_count_array . ";\n";
echo "var javascript_notation_array = " . $js_notation_array . ";\n";
?>
</script>

<script src="graph/graph.js"></script>

<div class="chartjs-size-monitor-shrink" style="height:20vh;width:40vw">

<canvas id="myChart"  ></canvas>
</div>


<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
	
    type: 'bar',
    data: {
        labels: javascript_notation_array,
        datasets: [{
            data: javascript_count_array,
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
            borderWidth: 1

        }]
    },
    options: {
		
    legend: {
        display: false

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
