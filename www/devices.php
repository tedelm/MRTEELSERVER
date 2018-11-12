<?php
include_once("include/common_db.php");

switch ($_GET['action']) {
    case "updateispindel":
 
        $ispindelName = $_POST['ispindelName'];
        $poly1 = $_POST['poly1'];
        $poly2 = $_POST['poly2'];
        $poly3 = $_POST['poly3'];      
        
        $SQL_INSERT_Poly = "INSERT INTO MyIspindles (`ID_`, `IspindelName`, `Poly1`, `Poly2`, `Poly3`) VALUES (NULL,'". $ispindelName ."','". $poly1 ."','". $poly2 ."','". $poly3 ."')";
							
        $SQL_INSERT_Poly_Result = mysql_query( $SQL_INSERT_Poly );
            IF(! $SQL_INSERT_Poly_Result ){
                $SQL_INSERT_Poly_Result_Status = "<font size='2' face='Arial' color='red'> Ooops! Database #Err1</font>";
            }ELSE{
            
                $SQL_INSERT_Poly_Result_Status = "<font size='2' face='Arial' color='green'>
                                                    Ispindel values updated! 
                                                    '".$ispindelName."': '".$poly1."' * tilt * tilt + '".$poly2."' * tilt '".$poly3."'
                                                    </font>
                                                 ";
            }			

    break;
}

//Get all ispindels - for select/option
$q_sql_all = mysql_query("SELECT DISTINCT(Name) FROM Data ORDER BY Timestamp DESC LIMIT 7;") or die(mysql_error());


?>
<html>
<head>
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
</center>

<h1>
Calibration
</br>
Select your iSpindel
</h1>
<form id='updatePoly' method='post' action='devices.php?action=updateispindel'>
<select name='IspindelName' id='updatePoly' style="font-family: Audiowide; font-size: 1em;color: #FF9900; width:450px;">
            <option value='iSpindel001'>Select one</option>    
    <?php
                if(isset($IspindelName)){
                    echo "<option value='' selected='selected'>".$IspindelName."</option>";
                }
                while($r_all = mysql_fetch_array($q_sql_all))
                {
                  echo "<option value='".$r_all['Name']."'>".$r_all['Name']."</option>";
                }
    ?>
</select>      
</br>
<h1>
Set calibration poly (e.g. <b>0.004415613</b> * $tilt * $tilt + <b>0.120848707</b> * $tilt <b>-6.159197377</b>)
</h1>
<input type='txt' name='poly1' value='0.004415613' style="font-family: Audiowide; font-size: 1em;color: #FF9900; width:450px;">
<input type='txt' name='poly2' value='0.120848707' style="font-family: Audiowide; font-size: 1em;color: #FF9900; width:450px;">
<input type='txt' name='poly3' value='-6.159197377' style="font-family: Audiowide; font-size: 1em;color: #FF9900; width:450px;">
</br>
</br>
<input type="submit" value='update' id='updatePoly' style="font-family: Audiowide; font-size: 1em;color: #FF9900; width:450px;">
</form>
<?php echo $SQL_INSERT_Poly_Result_Status; ?>
</body>