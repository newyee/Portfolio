<?php
session_start();
if(isset($_SESSION['id'])){
  $_SESSION = array();
  session_destroy();
  setcookie('id', '', time()-420000);
  setcookie('name', '', time()-420000);
}

header('Location:login.php');

?>