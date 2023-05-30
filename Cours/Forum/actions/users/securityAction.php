<?php
session_start();
if(!isset($_SESSION['auth'])){
    header('Location: C:/xampp/htdocs/projet WEB 1A2/Cours/login.php');
}