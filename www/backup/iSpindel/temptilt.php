<?php
include_once("include/common_db.php");
include_once("include/common_db_query.php");

echo $iSpindleID;
//Get all ispindles
$q_sql_temptilt = mysql_query("SELECT * FROM Data WHERE Name ='.$iSpindleID.' DESC LIMIT 10;") or die(mysql_error());

    while($r_temptilt = mysql_fetch_array($q_sql_temptilt))
    {

      echo $r_temptilt['Name'];

    }	

	

?>
  <html>
  <head>
    <script type="text/javascript" src="loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Time', 'Gravity'],
          ['01:00:00',  1.055011],
          ['01:30:00',  1.045011],
          ['02:00:00',  1.040011],
          ['01:00:00',  1.039011],
          ['01:30:00',  1.038011],
          ['02:00:00',  1.037011],
          ['01:00:00',  1.036011],
          ['01:30:00',  1.035011],
          ['02:00:00',  1.028011],
          ['01:30:00',  1.045011],
          ['02:00:00',  1.040011],
          ['01:00:00',  1.039011],
          ['01:30:00',  1.038011],
          ['02:00:00',  1.037011],
          ['01:00:00',  1.036011],
          ['01:30:00',  1.035011],
          ['02:00:00',  1.028011],
          ['01:30:00',  1.045011],
          ['02:00:00',  1.040011],
          ['01:00:00',  1.039011],
          ['01:30:00',  1.038011],
          ['02:00:00',  1.037011],
          ['01:00:00',  1.036011],
          ['01:30:00',  1.035011],
          ['02:00:00',  1.028011],		  
          ['02:30:00',  1.025011]
        ]);

        var options = {
          title: 'iSpindel Gravity id: xyz001  last 24h',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
	<style>
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 100px;
    margin: 4px 2px;
	width: 80%;
	height: 160px;
    -webkit-transition-duration: 0.4s; /* Safari */
    transition-duration: 0.6s;
    cursor: pointer;
}

.button2 {
    background-color: #008CBA; 
    color: white; 
    border: 2px solid #008CBA;
}

.button2:hover {
    background-color: white;
    color: #008CBA;
}	
	</style>
  </head>
  <body>
	<center>
    <div id="curve_chart" style="width: 900px; height: 600px"></div>
<div style="width: 100px; height: 150px"> </div>
<a href="../index.html"><button class="button button2">Home</button></a>
	
	</center>
  </body>
</html>