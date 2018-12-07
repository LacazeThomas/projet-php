<script src="/g9/assets/graph/graph.js"></script>

<div class="col-md-12">
        <canvas id="myChart2" style="height:20vh;width:40vw"></canvas>
</div>


<script>
var ctx = document.getElementById("myChart2").getContext('2d');
var myChart2 = new Chart(ctx, {
	
    type: 'doughnut',
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
            ]

        }]
    },
    options: {
		
    legend: {
        position: 'bottom'

    },
    title: {
		display: true,
		text: 'Proportion des avis'
	},
   }
});

</script>
