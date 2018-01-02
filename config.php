<?php  ob_start();
session_start();
include("includes/params.php");
function __autoload($ime_na_klasa){
    require_once "src/$ime_na_klasa.php";
}

$user = new User();
$forgotpassword = new ForgotPassword();
$note = new Note();

?>