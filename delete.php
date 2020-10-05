<?php
session_start();
require_once 'pdo.php';
if(! isset($_SESSION['name']))
{
    die("ACCESS DENIED");
}
if(isset($_POST['delete']) and isset($_POST['autos_id']))
{
    $sql = 'DELETE FROM autos WHERE autos_id = :us';
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute(array(
        ':us' => $_POST['autos_id']
    ));
    $_SESSION['success'] = 'Record Deteted';
    header('Location: index.php');
    return;
}
// if userid is not present
if( ! isset($_GET['autos_id']))
{
    $_SESSION['error'] = 'Missing Userid';
    header('Location: index.php');
    return;
}

$stmt = $pdo -> prepare('SELECT make, autos_id FROM autos where autos_id = :xyz ');
$stmt -> execute(array(
    ':xyz' => $_GET['autos_id']
));
$row = $stmt -> fetch(PDO::FETCH_ASSOC);
if($row === false)
{
    $_SESSION['error'] = 'Bad value for autos_id';
    header('Location: index.php');
    return;
}

?>
<html>
   <head>
            <title>KGSSV AKHIL KUMAR</title>
   </head> 
   <body>
       <p> Confirm: Deleting <?= $row['make'] ?> </p>
   <form method="POST">
    <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
    <input type="submit" value="Delete" name="delete">
    <a href="index.php">Cancel</a>
</form>
   </body>


</html>
