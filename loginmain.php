<?php
session_start();
require_once 'pdo.php';
if(isset($_POST['register']))
{
    header('Location: register.php');
    return;
}

if(isset($_POST['email']) and isset($_POST['pass']) and isset($_POST['login']))
{
    
    if(strlen($_POST['email']) < 1 or strlen($_POST['pass']) < 1 )
    {
        $_SESSION['error'] = 'Complete Credentials Required';
        header('Location: loginmain.php');
        return;
    }
    else
    {
        $email = htmlentities($_POST['email']);
        $pass = htmlentities($_POST['pass']);
        $sql ="SELECT * FROM users";
        $stmt = $pdo -> query($sql);
        while( $row = $stmt -> fetch(PDO::FETCH_ASSOC))
        {
            if($row['username'] == $email)
            {
                if($row['pass'] != $pass)
                {
                    $_SESSION['error'] = 'Please Check Your Credentials';
                    header('Location: loginmain.php');
                    return;
                }
                else if($row['pass'] == $pass)
                {
                    $_SESSION['name'] = $email;
                    $_SESSION['success'] = 'Login Success';
                    error_log('Login Success By : ' . $email);
                    header('Location: index.php');
                    return;
                }
            }

        }
        $_SESSION['error'] = 'User Not found';
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
    <title>Sign in</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>

<body>
    <img src="car.png" alt="">
        <div class="welcome-text">
            <p id="greet">Welcome To Autos Database</p>
            <p id="greet1">Sign In</p>

        </div>
        <div class="container">

        
        <?php
            if(isset($_SESSION['error']))
            {   echo ('<div class="message">');
                echo($_SESSION['error']);      //<span>Lorem ipsum dolor sit amet consectetur a dfsdfsds</span>
                unset($_SESSION['error']);
                echo('</div>');
            }
           
            if(isset($_SESSION['success']))
            {   echo ('<div class="message1">');
                echo('<p>'.$_SESSION['success'].'</p>');   //<span>Lorem ipsum dolor sit amet consectetur a dfsdfsds</span>
                unset($_SESSION['success']);
                echo('</div>');

            }
        ?>
        <div class="input-f">
            <form method="POST">
                <input id="f1" type="text" name="email" placeholder="UserName">
                <input id="f2" type="text" name="pass" placeholder="password">
                <br>
                <a href="forgot.php" style="position: relative; left: 48%; top: -15px; color: seashell;">Forgot password</a>
                <br>
                <span><input id="f3" type="submit" class="pass-id" value="Login"  name="login"></span>
                <span><input id="f4" type="submit" class="register-id"  value="Register" name="register"></span>
                
            </form>

        </div>

    </div>

</body>
                         
</html>