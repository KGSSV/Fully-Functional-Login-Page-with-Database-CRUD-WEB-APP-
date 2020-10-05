<?php
session_start();
if(isset($_POST['cancel']))
{
    header('Location: view.php');
    return;
}
if(isset($_SESSION['name']))
{
    if(isset($_POST['add']))
    {
    require_once "pdo.php";
    if(isset($_POST['make']) or isset($_POST['year']) or isset($_POST['mileage']) or isset($_POST['model']))
    {
        if( (is_numeric($_POST['year']) and is_numeric($_POST['mileage'])) === false)
        {
            echo "<p style='color: red;'>";
            echo "Mileage and year must be numeric";
            echo "</p>";
        }
        else
        {
           $sql = 'INSERT INTO autos (make, model, year, mileage) VALUES (:mk, :mo, :yr, :mi)';
           $stmt = $pdo -> prepare($sql);
           $stmt -> execute( array (
               ':mk' => htmlentities($_POST['make']) ,
               ':mo' => htmlentities($_POST['model']) ,
               ':yr' => htmlentities($_POST['year']),
               ':mi' => htmlentities($_POST['mileage'])
           ));
           $_SESSION['success'] = "Record inserted";
           header("Location: index.php");
           return;
        }
    }
  }
}

else
{
echo "<a href='login.php'>Click here to login </a> ";
print_r($_SESSION);
return;
}
?>
<html>
<head> 
    <title>KGSSV AKHIL KUMAR</title>
</head>
<body>
<p>Make is required</p>
<form method="POST">
    <p>make :<input name="make" type="text"></p>
    <p>model :<input name="model"></p>
    <p>year :<input name="year" ></p>
    <p>mileage :<input name="mileage"></p>
    <input type="submit" name="add" value="Add">
    <input type="submit" name="cancel" value="Cancel">
      
 </form>   
</body>
</html>