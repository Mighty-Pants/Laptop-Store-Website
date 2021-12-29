<?php
include_once '../classes/order.php';
?>
<?php
 $order = new Order();
 $getMoney_CurrentMonth = $order->getMoney_CurrentMonth()->fetch_assoc();
 $getMoney_CurrenYear = $order->getMoney_CurrentYear()->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en-US">
<body>


<div id="piechart"></div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Brand', 'Money per year'],
  ['Apple', 12],
  ['Samsung', 8],
  ['Oppo', 2],
  ['Vivo', 4],
  ['Xiaomi', 2],
  ['Realme', 8]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Brand', 'width':550, 'height':400};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>

</body>
</html>
