<?php
session_start();

unset($_SESSION["user_id"]);
unset($_SESSION["username"]);
unset($_SESSION["user_email"]);
unset($_SESSION["user_group"]);

header("Location:login.php");