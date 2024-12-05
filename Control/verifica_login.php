<?php

session_start();
if (!$_SESSION['email']) {
   header('Location: ../View/login.html');
   exit();
}


?>