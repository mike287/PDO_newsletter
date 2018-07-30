<?php

session_start();
require_once 'database.php';

if(isset($_POST['adminLogin']) && isset($_POST['adminPassword'])  )
{
    $login = filter_input(INPUT_POST,'adminLogin');
    $pass = filter_input(INPUT_POST,'adminPassword');

    $userQuery = $db->prepare('SELECT id, password FROM admins WHERE login = :login');
    $userQuery->bindValue(':login', $login, PDO::PARAM_STR );
    $userQuery->execute();

    $user = $userQuery->fetch();

    if($user && password_verify($pass, $user['password']))
    {
        echo "ok";
    }

    else{
        $_SESSION['errorLog'] = true;
        header('Location: admin.php');

    }
    exit();
    echo $userQuery->rowCount();



}else{
    header('Location: admin.php');
}