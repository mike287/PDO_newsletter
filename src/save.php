<?php

session_start();
require_once 'database.php';


if(isset($_POST['email']))
{
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

}else{
    header('Location: index.php');
}