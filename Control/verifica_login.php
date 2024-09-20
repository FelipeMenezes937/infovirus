<?php

session_start();
if (!$_SESSION['nome']) {
   header('Location: ../View/login.html');
   exit();
}


?>