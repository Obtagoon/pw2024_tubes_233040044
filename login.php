<?php
session_start();

if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

require 'function.php';

if (isset($_POST["login"])) {
    $login = loginfungsion($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
        label {
            display: block;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="login_box">
            <div class="login_header">
                <?php if (isset($login['error'])) : ?>
                    <p><?= $login['pesan']; ?></p>
                <?php endif; ?>
                <span>Login</span>
            </div>

            <form action="login.php" method="post">
                <div class="input_box">
                    <label for="username" autofocus autocomplete="off" required>Username</label>
                    <input type="text" id="username" name="username" class="input-field">

                </div>
                <div class="input_box">
                    <label for="password" autofocus autocomplete="off" required>Password</label>
                    <input type="text" id="password" name="password" class="input-field">


                </div>
                <div class="input_box">
                    <input type="submit" name="login" value="login" class="input-submit">
                </div>
                <p>
                    Didnt Have An Account? <a href="register.php">Login</a>
                </p>
        </div>
    </div>
    </form>
</body>

</html>