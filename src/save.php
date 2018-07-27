<?php

session_start();

if(isset($_POST['email']))
{
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if(empty($email))
    {
        $_SESSION['givenEmail'] = $_POST['email'];
        header('Location: index.php');
    }
    else
    {
        require_once 'database.php';

        $query = $db->prepare('INSERT INTO users VALUES (NULL, :email)');
        $query->bindValue(':email', $email, PDO::PARAM_STR );
        $query->execute();

        header('Location: confirmation.php');

    }

}else{
    header('Location: index.php');
}