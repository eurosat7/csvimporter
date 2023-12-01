<!doctype html>
<html lang="en">
<?php
    // having to type hint sucks.
    /** var string $title */
    $title ??= "no title";
?>
<head>
    <meta charset="utf-8"/>
    <title><?php echo $title; ?> - csvimporter</title>
    <link rel="stylesheet" href="assets/minimum.css"/>
</head>
<body>
    <h1><?php echo $title; ?></h1>
