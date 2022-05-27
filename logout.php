<?php
require_once "functions.php";
session_destroy();
$_SESSION=array();
header("location:index.php");