<?php
session_start();
require_once 'pdo.php';

if(isset($_POST['cancel']))
{
    header('Location: loginmail.php');
    return;
}
if(isset($_POST['email']))
{
    $sql = 'SELECT * from users WHERE username = :us';
    $stmt = $pdo -> prepare($sql);
    $stmt -> execute(array(
        'us' => $_POST['email']
    ));
    $row = $stmt -> fetch(PDO:: FETCH_ASSOC);
    if($row['username'] == $_POST['email'])
    {
        $name = $row['username'];
        $pass = $row['pass'];
        $sub = " Here is your Password";
        $msg = " Hello, \n Autos Database \n\n Account Name : $name \n\n Your Password : $pass \n\n Hope You Have Great Day ";
        $rec = "$name";
        mail($rec,$sub,$msg);
        $_SESSION['success'] = 'Password Sent to Mail';
        header('Location: loginmain.php');
        return;

    }
    else if($row['username'] != $_POST['email'])
    {
        $_SESSION['error'] = 'Password not Found';
        header('Location: loginmain.php');
        return;
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot</title>
    <link rel="stylesheet" type="text/css" href="style3.css">
</head>

<body>
    <img src="back2.png" alt="">

    <div class="welcome">
        <p id="size">Welcome to Autos Database - Support Page</p>
        <span id="greet1">Forgot Password</span>
        <div class="size">
            <span id="text">Enter your Registered Email Id :</span>
        </div>

    </div>
    <div class="container">
        <form method="POST">

            <input type="text" name="email" id="input-1">
            <input type="submit" value="Get Password" id="button-1">
            <input type="submit" value="Cancel" name="cancel" id="button-2">
        </form>

    </div>

</body>

</html>