<?php
require_once "pdo.php";
session_start();
if(! isset($_SESSION['name']))
{
    die("ACCESS DENIED");
}
if(isset($_POST['cancel']))
{
    header('Location: view1.php');
    return;
}
if(isset($_POST['make']) and isset($_POST['model']) and isset($_POST['year']) and isset($_POST['mileage']))
{
    
    $make = htmlentities($_POST['make']);  
    $model = htmlentities($_POST['model']);
    $year = htmlentities($_POST['year']);
    $mile = htmlentities($_POST['mileage']);
    if(strlen($make) < 1 or strlen($model) < 1 or strlen($year) < 1 or strlen($mile) < 1)
    {
        $_SESSION['error'] = 'All fields are required';
        header('Location: edit.php?autos_id='.urldecode($_POST['autos_id']));
        return;
    }
    else
    {
        if(! is_numeric($year))
        {
            $_SESSION['error'] ='Year must be numeric';
            header('Location: edit.php?autos_id='.urldecode($_POST['autos_id']));
            return;
        }
        elseif(! is_numeric($mile))
        {
            $_SESSION['error'] ='Mileage must be numeric';
            header('Location: edit.php?autos_id='.urldecode($_POST['autos_id']));
           return;
        }
        else
        {
            $sql = 'UPDATE AUTOS SET make = :mk , model = :mo , year = :yr , mileage = :mi WHERE autos_id = :au ';
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute(array(
                ':mk' => $_POST['make'],
                ':mo' => $_POST['model'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage'],
                ':au' => $_POST['autos_id']
            ));
            $_SESSION['success'] = 'Record edited';
            header('Location: index.php');
            return ;
        }
    }
} 

$stmt = $pdo -> prepare('SELECT * FROM AUTOS WHERE autos_id = :zip');
$row = $stmt -> execute(array(
    ':zip' => $_GET['autos_id']
));
$row = $stmt -> fetch(PDO:: FETCH_ASSOC);


if($row === false)
{
    $_SESSION['error'] = 'Bad value for id';
    header('Location: view1.php');
    return;
}
?>
<html>
    <head>
        <title>KGSSV AKHIL KUMAR</title>
  
    </head>
    <body>
        <?php 
        echo "<h1>Editing Automobiles </h1>";
        if(isset($_SESSION['error']))
        {
            echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']);
        }
        ?>
       <form method="POST">
           <p>Make : <input type="text" name="make" value="<?= $row['make']; ?>"></p>
           <p>Model : <input type="text" name="model" value="<?= $row['model']; ?>"></p>
           <p>Year : <input type="text" name="year" value="<?= $row['year']; ?>"></p>
           <p>Mileage : <input type="text" name="mileage" value="<?= $row['mileage'];?>"></p>
           <input type="hidden" name="autos_id" value="<?= $row['autos_id']; ?>">
           <input type="submit" value="Save">
           <input type="submit" name="cancel" value="Cancel">
        </form>
    </body>
</html>

