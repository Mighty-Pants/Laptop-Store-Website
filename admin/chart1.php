<?php
include_once '../classes/order.php';
?>

<?php
    $order = new Order();
    $getQuater1 = $order->getQuarter1()->fetch_assoc();
    $getQuater2 = $order->getQuarter2()->fetch_assoc();
    $getQuater3 = $order->getQuarter3()->fetch_assoc();
    $getQuater4 = $order->getQuarter4()->fetch_assoc();
?>
<!DOCTYPE HTML>
<html>
<head>
<script type="text/javascript">
window.onload = function () {

var chart = new CanvasJS.Chart("chartContainer", {
	theme: "light1", // "light2", "dark1", "dark2"
	animationEnabled: false, // change to true		
	title:{
		text: ""
	},
	data: [
	{
		// Change type to "bar", "area", "spline", "pie",etc.
		type: "column",
		dataPoints: [
			{ label: "Quarter I",  y: <?php echo $getQuater1['total_money'] ?>  },
			{ label: "Quarter II",  y: <?php echo $getQuater2['total_money'] ?>  },
			{ label: "Quarter III",  y: <?php echo $getQuater3['total_money'] ?>  },
			{ label: "Quarter IV",  y: <?php echo $getQuater4['total_money'] ?>  }
		]
	}
	]
});
chart.render();

}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>
</body>
</html>