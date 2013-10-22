<?php
include 'inc/common.php';
init_session();

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>PHP course task 3</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />

</head>
<body>

<div class="container">
    <div class="header">
        <?php include 'header_menu.php'; ?>
        <h3 class="text-muted">Message board</h3>
    </div>