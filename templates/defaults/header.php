<?php

declare(strict_types=1);

/**
 * @var CsvImportController $controller
 * @var TemplateEngine $te
 * @var array<string,mixed> $vars
 * @var string $title
 */
$title ??= 'no title';
?><!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title><?php $te->esc($title); ?> - csvimporter</title>
        <link rel="stylesheet" href="assets/minimum.css"/>
    </head>
    <body>
        <h1><?php $te->esc($title); ?></h1>