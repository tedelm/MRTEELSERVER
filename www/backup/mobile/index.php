<?php

// Show the Angle/Temperature chart
// GET Parameters:
// hours = number of hours before now() to be displayed
// name = iSpindle name
 
include_once("../include/common_db.php");
//include_once("include/common_db_query.php");



switch ($_GET['action']) {
    case change:
			$iSpindelName = $_GET[iSpindelName];
	
			//Select all data
			$changeQuery="SELECT * FROM Data WHERE Name='".$iSpindelName."' ORDER BY Timestamp DESC LIMIT 1";
			$changeResult=mysqli_query($con,$changeQuery);
			    while($ChangeRow = mysqli_fetch_assoc($changeResult)){
				
					$Timestamp = $ChangeRow['Timestamp'];
					$iSpindelName = $ChangeRow['Name'];
					$Temperature = $ChangeRow['Temperature'];
					$Battery = $ChangeRow['Battery'];
					$Gravity = $ChangeRow['Gravity'];
					
					//Batterylife
					$BatteryLife = round(((100/0.7)*($Battery-3)), 0);
					if($BatteryLife < 3.1){
						$BatteryLife = 0;
						$BatteryLifeBar = 25;
						$BatteryLifeBarColor = "red";
					}else{
						
						$BatteryLifeBar = $BatteryLife;
						$BatteryLifeBarColor = "#1aff00";
						if($BatteryLifeBar < 3.2){
							$BatteryLifeBar = 25;
						}
						if($BatteryLifeBar > 3.7){
							$BatteryLifeBar = 100;
							$BatteryLife = 100;
						}						
					}
					//Temperature
					$TemperatureBar = round(((100/31)*($Temperature)), 1);
					
					//Gravity
					//Calculate from tilt to Plato
					//$Plato = 0,004415613 * ($Gravity) * ($Gravity) + 0,120848707 * ($Gravity) - 6,159197377
					//$GravitySG = round(1+($Plato / (258.6 - ($Plato/258.2) * 227.1)),4);
					
					//Calculate with values that are plato to SG eg 1.055
					$GravitySG = round(1+($Gravity / (258.6 - ($Gravity/258.2) * 227.1)),4);
					
					$GravitySGBar = 50;
					
					if($GravitySG > 1.200){
						$GravitySGBar = 100;
					}elseif($GravitySG > 1.090){
						$GravitySGBar = 75;
					}elseif($GravitySG > 1.070){
						$GravitySGBar = 50;
					}elseif($GravitySG > 1.030){
						$GravitySGBar = 45;
					}elseif($GravitySG > 1.025){
						$GravitySGBar = 40;
					}elseif($GravitySG > 1.016){
						$GravitySGBar = 30;
					}else{
						$GravitySGBar = 25;
					}
					
					
				}
        break;
		Default:
				if(!isset($iSpindelName)){
				// Perform queries
					$sql="SELECT DISTINCT Name FROM Data";
					$result=mysqli_query($con,$sql);

				//Select all data
					$sql2="SELECT * FROM Data";
					$result2=mysqli_query($con,$sql2);
					while($row2 = mysqli_fetch_assoc($result2)){
						$iSpindelName = $row2['Name'];
					}
			//Select all data
			$changeQuery="SELECT * FROM Data WHERE Name='".$iSpindelName."' ORDER BY Timestamp DESC LIMIT 1";
			$changeResult=mysqli_query($con,$changeQuery);
			    while($ChangeRow = mysqli_fetch_assoc($changeResult)){
				
					$Timestamp = $ChangeRow['Timestamp'];
					$iSpindelName = $ChangeRow['Name'];
					$Temperature = $ChangeRow['Temperature'];
					$Battery = $ChangeRow['Battery'];
					$Gravity = $ChangeRow['Gravity'];
					
					//Batterylife
					$BatteryLife = round(((100/0.7)*($Battery-3)), 0);
					if($BatteryLife < 3.1){
						$BatteryLife = 0;
						$BatteryLifeBar = 25;
						$BatteryLifeBarColor = "red";
					}else{
						
						$BatteryLifeBar = $BatteryLife;
						$BatteryLifeBarColor = "#1aff00";
						if($BatteryLifeBar < 3.2){
							$BatteryLifeBar = 25;
						}
						if($BatteryLifeBar > 3.7){
							$BatteryLifeBar = 100;
							$BatteryLife = 100;
						}						
					}
					//Temperature
					$TemperatureBar = round(((100/31)*($Temperature)), 1);
					
					//Gravity
					//Calculate from tilt to Plato
					//$Plato = 0,004415613 * ($Gravity) * ($Gravity) + 0,120848707 * ($Gravity) - 6,159197377
					//$GravitySG = round(1+($Plato / (258.6 - ($Plato/258.2) * 227.1)),4);
					
					//Calculate with values that are plato to SG eg 1.055
					$GravitySG = round(1+($Gravity / (258.6 - ($Gravity/258.2) * 227.1)),4);
					
					$GravitySGBar = 50;
					
					if($GravitySG > 1.200){
						$GravitySGBar = 100;
					}elseif($GravitySG > 1.090){
						$GravitySGBar = 75;
					}elseif($GravitySG > 1.070){
						$GravitySGBar = 50;
					}elseif($GravitySG > 1.030){
						$GravitySGBar = 45;
					}elseif($GravitySG > 1.025){
						$GravitySGBar = 40;
					}elseif($GravitySG > 1.016){
						$GravitySGBar = 30;
					}else{
						$GravitySGBar = 25;
					}
					
					
				}
				}		
		break;
} 


?>
<html>
<head>
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
.buttonB {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 16px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 75px;
    margin: 4px 2px;
	width: 33%;
	height: 160px;
    -webkit-transition-duration: 0.4s; 
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


<font style="font-size: 100px;font-family:'Lucida Sans Unicode';color: #616161;">iSpindel</font></br>
<!-- Create dropdown to select ispindel-->

<div align="left">
<?php
   // Perform queries
	$sql="SELECT DISTINCT Name FROM Data";
	$result=mysqli_query($con,$sql);
    while($row = mysqli_fetch_assoc($result))
    {
        $iSpindelNameChange = $row['Name'];
		echo "<a href='index.php?action=change&iSpindelName=".$iSpindelNameChange."'><button class='buttonB button2'>".$iSpindelNameChange."</button></a>";
    }
?>
</div>

</br>
<font style="font-size: 50px;font-family:'Lucida Sans Unicode';color: #616161;">id: <?php echo $iSpindelName; ?></font></br>
<font style="font-size: 50px;font-family:'Lucida Sans Unicode';color: #616161;">Last sync: <?php echo $Timestamp; ?></font></br>
</br>
</br>

<div style="height:30px;width:100%;">

<font style="font-size: 70px;font-family:'Lucida Sans Unicode';color: #616161;">Gravity</font>
<div style="background-color:#f1f1f1">
  <div style="height:80px;width:<?php echo $GravitySGBar; ?>%;background-color:#19C5F5;font-size: 70px;font-family:'Lucida Sans Unicode';color: #616161;"><?php echo $GravitySG; ?>/<?php echo $Gravity; ?></div>
</div><br>
<font style="font-size: 70px;font-family:'Lucida Sans Unicode';color: #616161;">Temp</font>
<div style="background-color:#f1f1f1">
  <div style="height:80px;width:<?php echo $TemperatureBar; ?>%;background-color:#fcab03;font-size: 70px;font-family:'Lucida Sans Unicode';color: #616161;"><?php echo $Temperature; ?>&#x2103;</div>
</div><br>
<font style="font-size: 70px;font-family:'Lucida Sans Unicode';color: #616161;">Volt</font>
<div style="background-color:#f1f1f1">
  <div style="height:80px;width:<?php echo $BatteryLifeBar;?>%;background-color:<?php echo $BatteryLifeBarColor;?>;font-size: 70px;font-family:'Lucida Sans Unicode';color: #616161;"><?php echo $Battery;?>v <?php echo $BatteryLife;?>%</div
</div>
</div>
<center>
<div style="width: 100px; height: 150px"> </div>
<a href="../index.html"><button class="button button2">Home</button></a>
</center>
</body>
</html>
<?php
// Free result set
mysqli_free_result($result);
mysqli_close($con);
?>