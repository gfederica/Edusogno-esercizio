<?php

// imposto la connessione al db locale
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$db = 'edu_test';

$conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error);
