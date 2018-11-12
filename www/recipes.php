<?php
include_once("include/common_db.php");

switch ($_GET['action']) {
    case "updateMyRecipes":
 
        $IspindelName = $_POST['IspindelName'];
        $MyRecipeName = $_POST['MyRecipeName'];
        $MyRecipeOG = $_POST['MyRecipeOG'];
        $MyRecipeCalcFG = $_POST['MyRecipeCalcFG'];      
        $MyRecipeBrewDay = $_POST['MyRecipeBrewDay'];

        $SQL_INSERT_Recipes = "INSERT INTO MyRecipes (`ID_`, `IspindelName`, `MyRecipeName`, `MyRecipeOG`, `MyRecipeCalcFG`, `MyRecipeBrewDay`) VALUES (NULL,'". $IspindelName ."','". $MyRecipeName ."','". $MyRecipeOG ."','". $MyRecipeCalcFG ."','". $MyRecipeBrewDay ."')";
							
        $SQL_INSERT_Recipes_Result = mysql_query( $SQL_INSERT_Recipes );
            IF(! $SQL_INSERT_Recipes_Result ){
                $SQL_INSERT_Recipes_Result_Status = "<font size='2' face='Arial' color='red'> Ooops! Database #Err1</font>";
            }ELSE{
            
                $SQL_INSERT_Recipes_Result_Status = "<font size='3' face='Arial' color='green'>
                                                    Recipe values updated! '".$MyRecipeName."'
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
<center>
<h1>
Brew recipe information
</h1>
<h1>

</h1>
</br>
<form id='updateMyRecipes' method='post' action='recipes.php?action=updateMyRecipes'>
<table border="0">
<tr>
    <td><h1>My Ispindel</td><td>
    <select name='IspindelName' id='ispindelform' style="font-family: Audiowide; font-size: 1em;color: #FF9900; width:450px;">
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
    </h1></td>
</tr>
<tr>
    <td><h1>My Recipe Name</td><td> <input type='txt' name='MyRecipeName' value='My Recipe Name' style="font-family: Audiowide; font-size: 0.7em;color: #FF9900; width:450px;"></h1></td>
</tr>
<tr>
    <td><h1>My Recipe OG </td><td> <input type='txt' name='MyRecipeOG' value='1.055' style="font-family: Audiowide; font-size: 0.7em;color: #FF9900; width:450px;"></h1></td>
</tr>
<tr>
    <td><h1>My Recipe Calculated FG</td><td>  <input type='txt' name='MyRecipeCalcFG' value='1.014' style="font-family: Audiowide; font-size: 0.7em;color: #FF9900; width:450px;"></h1></td>
</tr>
<tr>
    <td><h1>Brew date </td><td> <input type='txt' name='MyRecipeBrewDay' value='2018-12-24' style="font-family: Audiowide; font-size: 0.7em;color: #FF9900; width:450px;"></h1></td>
</tr>
</table>
<input type="submit" value='update' id='updateMyRecipes' style="font-family: Audiowide; font-size: 0.7em;color: #FF9900; width:450px;hight:75px;">
</form>
<?php echo $SQL_INSERT_Recipes_Result_Status; ?>
</body>
</html>
