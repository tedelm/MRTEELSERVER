<?php
include_once("include/common_db.php");

switch ($_GET['action']) {
    case "selectIspindel":
 
        $selectIspindelName = $_POST['selectIspindelName'];

        $q_sql_everything = mysql_query("SELECT * FROM Data WHERE Name='$selectIspindelName' ORDER BY Timestamp DESC LIMIT 1;") or die(mysql_error());
        while($r_everything = mysql_fetch_array($q_sql_everything))
        {
            $timestamp = $r_everything['Timestamp'];
            $Name =  $r_everything['Name'];
            #$ID =  $r_everything['ID_'];
            $Angle =  $r_everything['Angle'];            
            $Temperature =  $r_everything['Temperature'];
            $Battery =  $r_everything['Battery'];
            $Gravity =  $r_everything['Gravity'];      
            $RSSI =  $r_everything['RSSI'];      
        }	

    break;
}
//Get all ispindels - for select/option
$q_sql_all = mysql_query("SELECT DISTINCT(Name) FROM Data ORDER BY Timestamp DESC LIMIT 7;") or die(mysql_error());


//Chart
$q_sql_chart = mysql_query("SELECT * FROM (SELECT  * FROM Data WHERE Name='$Name' ORDER BY Timestamp DESC) sub ORDER BY Timestamp ASC;") or die(mysql_error());

//Recipe
$q_sql_ispindelrecipe = mysql_query("SELECT * FROM MyRecipes WHERE IspindelName='$Name' ORDER BY ID_ DESC LIMIT 1;") or die(mysql_error());
while($r_ispindelrecipe = mysql_fetch_array($q_sql_ispindelrecipe))
{
  $MyRecipeName = $r_ispindelrecipe['MyRecipeName'];
  $MyRecipeOG = $r_ispindelrecipe['MyRecipeOG'];
  $MyRecipeCalcFG = $r_ispindelrecipe['MyRecipeCalcFG'];
  $MyRecipeBrewDay = $r_ispindelrecipe['MyRecipeBrewDay'];  
}

//Poly calibration
$q_sql_ispindelcal = mysql_query("SELECT * FROM MyIspindles WHERE IspindelName='$Name' ORDER BY ID_ DESC LIMIT 1;") or die(mysql_error());
while($r_ispindelcal = mysql_fetch_array($q_sql_ispindelcal))
{
  $Poly1 = (float)$r_ispindelcal['Poly1'];
  $Poly2 = (float)$r_ispindelcal['Poly2'];
  $Poly3 = (float)$r_ispindelcal['Poly3'];  
   
}

//Calculate Plato from tilt
#$Plato = 0.004415613 * $Angle * $Angle + 0.120848707 * $Angle - 6.159197377;
if(strpos($Poly3, '-') !== false){
    $Poly3 = str_replace("-","",$Poly3);
    $Poly3 = (float)$Poly3;
    $Plato = $Poly1 * $Angle * $Angle + $Poly2 * $Angle - $Poly3;
}else{
    $Plato = $Poly1 * $Angle * $Angle + $Poly2 * $Angle + $Poly3;
}

//Calculate SG
 #$SG = 1+($plato/ (258.6–(($plato/258.2)*227.1)))
$Plato_1 = ($Plato / 258.2) * 227.1;
$Plato_2 =  258.6 - $Plato_1;
$Plato_3 =  $Plato/$Plato_2;
$SG = 1 + $Plato_3;

#ABV = (OG - FG) * 131.25
$ABV_a = (int)$MyRecipeOG - round($SG, 3);
$ABV_b = (float)str_replace("-","",$ABV_a);
$ABV = $ABV_b * 131.25;

?>
<html>
<head>
    <script type="text/javascript" src="js/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Time', 'SG', 'Temp', 'Battery'],
            <?php
            while($r_chart = mysql_fetch_array($q_sql_chart))
            {
                $Timestamp = $r_chart['Timestamp'];
                    $YYYYmmdd = explode(" ", $Timestamp);
                    $HHMMSS = explode(":", $Timestamp);
                $Temperature =  (float)$r_chart['Temperature'];
                $Battery =  $r_chart['Battery'];
                    $BatteryRound = round($Battery,2);
                $Angle =  (float)$r_chart['Angle'];

                if(strpos($Poly3, '-') !== false){
                    $Poly3 = str_replace("-","",$Poly3);
                    $Poly3 = (float)$Poly3;
                    $Plato = $Poly1 * $Angle * $Angle + $Poly2 * $Angle - $Poly3;
                }else{
                    $Plato = $Poly1 * $Angle * $Angle + $Poly2 * $Angle + $Poly3;
                }
                $Plato_1 = ($Plato / 258.2) * 227.1;
                $Plato_2 =  258.6 - $Plato_1;
                $Plato_3 =  $Plato/$Plato_2;
                $SG = 1 + $Plato_3;          
                    $SG_Small = explode(".", round($SG, 3));                    
                
                
                echo "['$YYYYmmdd[0] $YYYYmmdd[1]', $SG_Small[1], $Temperature, $BatteryRound],";
            }

            ?>
        ]);

        var options = {
          title: 'SG (1.050 = 50 in chart) /Temp',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
<link rel="stylesheet" type="text/css" href="css/default.css">
<style>
@import url('https://fonts.googleapis.com/css?family=Audiowide');
</style>
</head>

<body>
<center>
<table border='0'>
    <tr>
        <td>
            <img src='img/mrteellogo.png' width='55' height='75'>
        </td>
        <td>
            <div id="container">
            <p>
            <a href="index.php">MRTEELSERVER</a>
            </p>
            </div>
        </td>
    </tr>
</table>
<table border='0'>    
    <tr>
        <td>
          <div class="cardMenu card-4"><a href='index.php'>Dashboard</a></div>
        </td>
        <td>
          <div class="cardMenu card-4"><a href='devices.php'>Devices</a></div>            
        </td>
        <td>
          <div class="cardMenu card-4"><a href='recipes.php'>Recipes</a></div>            
        </td>         
    </tr>
</table>
<table border='0'>    
    <tr>
        <td>
         <div class="cardLongHeadline card-4">
            iSpindel:
        </div>
        </td>
        <td>
        <div class="cardLongHeadline card-4">
        recipe:
        </div>
        </td>
    </tr>
    <tr>
        <td>
        <div class="cardLong card-4">
        <form id='selectIspindel' class='ispindelform' method='post' action='index.php?action=selectIspindel'>
            <select name='selectIspindelName' id='ispindelform' style="font-family: Audiowide; font-size: 1em;color: #FF9900; width:450px;" onchange='if(this.value != 0) { this.form.submit(); }'>
            <option value='iSpindel001'>Select one</option>
            <?php
                if(isset($selectIspindelName)){
                    echo "<option value='' selected='selected'>".$selectIspindelName."</option>";
                }
                while($r_all = mysql_fetch_array($q_sql_all))
                {
                  echo "<option value='".$r_all['Name']."'>".$r_all['Name']."</option>";
                }
            ?>
            </select>         
        </form>
        <!-- <?php echo $Name; ?> -->
        </div>
        </td>
        <td>
        <div class="cardLong card-4">
        <?php if(isset($MyRecipeName)){
        echo $MyRecipeName;
        }else{
            echo "N/A";
        };
        ?>    
        </div>
        </td>
    </tr>
</table>
    
</br>
<div class="card card-small">
    Temp</br></br>
    <div class="bigtext">
    <?php echo round($Temperature, 2); ?>
    </div>
</div>
<div class="card card-small">
    Tilt</br></br>
    <div class="bigtext">
    <?php echo round($Angle, 2); ?>
    </div>
</div>
<div class="card card-small">
    Battery</br></br>
    <div class="bigtext">
    <?php echo round($Battery, 2); ?>
    </div>
</div>
<div class="card card-small">
    Ispindel Plato</br></br>
    <div class="bigtext">
    <?php echo round($Gravity, 2); ?>
    </div>
</div>
<div class="card card-small">
    RSSI</br></br>
    <div class="bigtext">
    <?php echo round($RSSI, 0); ?>
    </div>
</div>
</br>

<div class="card card-small">
    PLATO</br></br>
    <div class="bigtext">
    <?php echo round($Plato, 2); ?>
    </div>
</div>
<div class="card card-small">
    SG</br></br>
    <div class="bigtext">
    <?php echo round($SG, 3); ?>
    </div>
</div>
<div class="card card-small">
    OG</br></br>
    <div class="bigtext">
    <?php if(isset($MyRecipeOG)){
        echo round($MyRecipeOG, 3);
        }else{
            echo "N/A";
        };
    ?>
    </div>
</div>
<div class="card card-small">
    Calc FG</br></br>
    <div class="bigtext">
    <?php if(isset($MyRecipeCalcFG)){
        echo round($MyRecipeCalcFG, 3);
        }else{
            echo "N/A";
        };
    ?>
    </div>
</div>
<div class="card card-small">
    ABV</br></br>
    <div class="bigtext">
    <?php if(isset($ABV)){
        echo round($ABV, 2);
        }else{
            echo "N/A";
        };
    ?>
    </div>
</div>

<div id="curve_chart" class="card-small" style="width: 900px; height: 600px"></div>
</center>
</body>
</html>
