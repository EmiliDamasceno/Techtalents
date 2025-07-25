<?php
session_start();

if (!isset($_SESSION['empresa'])) {   
    header("Location: login.html");    
    exit();
}
?>