<?php session_start(); ob_start(); ?>
<?php require_once 'config.php'; ?>
<!doctype html>
<html lang="en">
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <meta charset="UTF-8">
    <title>SIPUT | Sistem Informasi Puskesmas Terpadu</title>

    <!--styles-->
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="css/jquery.datetimepicker.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/select2.min.css">
    <style>
    #obat-fieldset-one > tbody > tr:first-child > td > .fa-minus-square { display:none; }
    @media all and (max-width: 900px) {
        .content {padding-left:5px; padding-right:5px;}
        .container-stat { border: 1px solid #ddd; margin-right: 10px; margin-top: 10px; padding: 10px; text-align: center; }
    }
    @media all and (min-width: 901px) { 
        .content .box-container .container-33 {
            width: 33%;
        }
        .container-stat { border: 1px solid #ddd; margin-left: 10px; padding: 10px; text-align: center; }
    }
    </style>
</head>
<body>
