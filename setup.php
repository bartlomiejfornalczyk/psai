<?php
$srv = "localhost";
$db = "psai";
$u = "root";
$p = "";

$conn = new mysqli($srv, $u, $p, $db);
error_reporting(0);
session_start();
