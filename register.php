<?php
require_once 'pdo.php';
session_start();
if(isset($_POST['cancel']))
{
    sleep(2);
    header('location: loginmain.php');
    return;
}
if(isset($_POST['email']) and isset($_POST['password']) and isset($_POST['unique']))
{
    if(strlen($_POST['email']) < 1 or strlen($_POST['password']) < 1 or strlen($_POST['unique']) < 1)
    {
        $_SESSION['error'] = 'Enter all Fields';
        header('Location: register.php');
        return;
    }
    else
    {
        if(isset($_POST['email']))
        {
            $sql = 'SELECT username from users where username = :us';
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute(array(
                ':us' => htmlentities($_POST['email'])
            ));
            $row = $stmt -> fetch(PDO::FETCH_ASSOC);

            if($row['username'] == $_POST['email'])
            {
                $_SESSION['error'] = 'user already exist with this username';
                sleep(2);
                header('Location: register.php');
                return;
            }
            else if($row['username'] != $_POST['email'])
            {
                if($_POST['unique'] == 'XABC1357')
                {
                    $sql = 'INSERT into users( username , pass) values ( :us , :pa)';
                    $stmt = $pdo -> prepare($sql);
                    $stmt -> execute(array(
                        ':us' => htmlentities($_POST['email']),
                        ':pa' => htmlentities($_POST['password'])
                    ));
                    sleep(3);
                    $_SESSION['success'] = 'Registration Successful';
                    header('Location: loginmain.php');
                    return;
                }
                else
                {
                    $_SESSION['error'] = 'Unique Code Invalid';
                    header('Location: register.php');
                    return;
                }
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style2.css">
    <title>Register - Database</title>
</head>

<body>
    <img src="back.png">
    <div class="welcome-t">
        <p id="message1">Welcome To autos Database</p>
        <p id="message2">Register Now</p>
    </div>
    <div class="container">
    <?php
            if(isset($_SESSION['error']))
            {   echo ('<div class="feedback">');
                echo('<p style="color: white;">'.$_SESSION['error'].'</p>');      //<span>Lorem ipsum dolor sit amet consectetur a dfsdfsds</span>
                unset($_SESSION['error']);
                echo('</div>');
            }
        ?>
        <div class="inputs">
            <form method="POST">
                <input type="text" name="email" id="f1" placeholder="Username">
                <input type="text" name="password" id="f2" placeholder="password">
                <input type="text" name="unique" id="f3" placeholder="Unique Code">
                <input type="submit" value="Register" id="f4" name="register">
                <input type="submit" value="Cancel" id="f5" name="cancel">
            </form>
        </div>
    </div>
</body>

</html>
