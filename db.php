<?php
function OpenCon()
{
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'todouser';

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName) or die ("Database connection failed");

    return $conn;
}

function CloseCon($conn)
{
    $conn -> close();
}