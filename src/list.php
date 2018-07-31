<?php

session_start();
require_once 'database.php';

$_SESSION['adminLogin'] = $_POST['adminLogin'];

if ( ($_SESSION['adminSession']) != true )
{
    if ( isset($_POST['adminLogin']) && isset($_POST['adminPassword']) )
    {
        $login = filter_input(INPUT_POST, 'adminLogin');
        $pass  = filter_input(INPUT_POST, 'adminPassword');

        $userQuery = $db->prepare('SELECT id, password FROM admins WHERE login = :login');
        $userQuery->bindValue(':login', $login, PDO::PARAM_STR);
        $userQuery->execute();

        $user = $userQuery->fetch();

        if ( $user && password_verify($pass, $user['password']) )
        {
            $_SESSION['adminSession'] = true;
        }
        else
        {
            $_SESSION['errorLog'] = true;
            header('Location: admin.php');
            exit();
        }
    }
    else
    {
        header('Location: admin.php');
        exit();
    }
}

$usersListQuery = $db->query('SELECT * FROM users');
$users          = $usersListQuery->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../docs/favicon.ico">

<title>Cover Template for Bootstrap</title>

<!-- Bootstrap core CSS -->
<link href="../dist/css/bootstrap.min.css" rel="stylesheet">

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="cover.css" rel="stylesheet">

<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--[if lt IE 9]>
<script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
<script src="../docs/assets/js/ie-emulation-modes-warning.js"></script>

<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <div class="inner cover">
                <h1 class="cover-heading">Lista zapisanych użytkowników: <?php echo $usersListQuery->rowCount() ?></h1>
                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th scope="col" class="text-center">ID</th>
                        <th scope="col" class="text-center">Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ( $users as $user )
                    {
                        echo "<tr><td>{$user['id']}</td><td>{$user['email']}</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <a href="logOut.php">
                <button type="button" id="logOut" class="btn btn-primary">Wyloguj</button>
            </a>

            <div class="mastfoot">
                <div class="inner">
                    <p>Cover template for <a href="http://getbootstrap.com">Bootstrap</a>, by <a
                                href="https://twitter.com/mdo">@mdo</a>.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../docs/assets/js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>
<head>
