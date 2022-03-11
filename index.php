<?php
require_once('includes/config.php');

require_once('controllers/EmployeeController.php');

$indexController = new EmployeeController();

if(isset($_GET['ajax'])){
    return $indexController->ajax();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>
<body>

    <?php

    $indexController->getView();

    ?>
</body>
</html>
