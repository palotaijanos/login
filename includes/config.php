<?php
$hostname = 'db';
$username = 'root';
$password = '';
$database = 'employees';

global $con;
$con = mysqli_connect($hostname, $username, $password, $database);