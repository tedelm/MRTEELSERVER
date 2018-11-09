<?php
include_once("include/common_db.php");
include_once("include/common_db_query.php");

switch ($_GET['action']) {
    case "updateispindel":
 
        $ispindelName = $_POST['ispindelName'];
        $poly1 = $_POST['poly1'];
        $poly2 = $_POST['poly2'];
        $poly3 = $_POST['poly3'];      
        
        $SQL_INSERT_Poly = "INSERT INTO MyIspindles (`ID`, `IspindelName`, `Poly1`, `Poly2`, `Poly3`) VALUES (NULL,'". $ispindelName ."','". $poly1 ."','". $poly2 ."','". $poly3 ."')";
							
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
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/default.css">
<style>
@import url('https://fonts.googleapis.com/css?family=Audiowide');
</style>
</head>

<body>
<h1>
Set calibration poly (e.g. <b>0.004415613</b> * $tilt * $tilt + <b>0.120848707</b> * $tilt <b>-6.159197377</b>;)
</h1>
</br>
<form id='updatePoly' method='post' action='devices.php?action=updateispindel'>
<input type='txt' name='ispindelName' value='iSpindel001'></br>
<input type='txt' name='poly1' value='0.004415613'><input type='txt' name='poly2' value='0.120848707'><input type='txt' name='poly3' value='-6.159197377'>
<input type="submit" value='update' id='updatePoly'>
</form>
<?php echo $SQL_INSERT_Poly_Result_Status; ?>
</body>