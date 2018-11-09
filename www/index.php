<?php
include_once("include/common_db.php");
include_once("include/common_db_query.php");

//Get all ispindles
$q_sql_everything = mysql_query("SELECT * FROM Data ORDER BY Name DESC LIMIT 1;") or die(mysql_error());

    while($r_everything = mysql_fetch_array($q_sql_everything))
    {

        echo "</br> Timestamp: ";
      echo $r_everything['Timestamp'];
      echo "</br> Name: ";
      echo $r_everything['Name'];
      echo "</br> ID: ";
      echo $r_everything['ID'];
      echo "</br> Angle: ";
      echo $r_everything['Angle'];            
      echo "</br> Temperature: ";
      echo $r_everything['Temperature'];
      echo "</br> Battery: ";
      echo $r_everything['Battery'];
      echo "</br> Gravity: ";
      echo $r_everything['Gravity'];      
      echo "</br> RSSI: ";
      echo $r_everything['RSSI'];                    

    }	

	
?>
<html>
<head>
</head>
    <body>
        Main site
    </body>
</html>
