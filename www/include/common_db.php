<?php

// configure your database connection here:
define('DB_SERVER',"localhost");
define('DB_NAME',"mrteeldb");
define('DB_USER',"mrteel");
define('DB_PASSWORD',"nosecretnow");
 
$conn = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
if(is_resource($conn))
{
  mysql_select_db(DB_NAME, $conn);
  mysql_query("SET NAMES 'ascii'", $conn);
  mysql_query("SET CHARACTER SET 'ascii'", $conn);
}
 
define("defaultTimePeriod", 24); // Timeframe for chart
?>
