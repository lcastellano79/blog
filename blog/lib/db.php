<?php
$user = 'blogadmin';
$pass = 'secret.43';
$db = 'blog';

$dbc = new mysqli('localhost', $user, $pass, $db);

if (!$dbc) {
    echo "Error: Unable to connect to MySQL.<br>" . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . "<br>" . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . "<br>" . PHP_EOL;
    exit;
}

