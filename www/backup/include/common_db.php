<?php

// configure your database connection here:
define('DB_SERVER',"localhost");
define('DB_NAME',"iSpindle");
define('DB_USER',"iSpindle");
define('DB_PASSWORD',"piiot");

$con=mysqli_connect("localhost","iSpindle","piiot","iSpindle");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 
define("defaultTimePeriod", 24); // Timeframe for chart
?>
