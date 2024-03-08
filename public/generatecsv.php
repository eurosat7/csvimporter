<?php

declare(strict_types=1);

// please only run from inside docker.
// > make docker-php-csv

$rows = 20_000;
$filename = dirname(__DIR__) . '/generated_entities_for_testing.csv';

echo 'writing to file: ', $filename, "\r\n";
$fh = fopen($filename, 'wb');
if ($fh === false) {
    die('cannot create ' . $filename);
}
fwrite($fh, "name,description,cost,amount;\r\n");
while ($rows > 0) {
    $rows--;
    echo '.';
    if ($rows % 100 === 0) {
        echo ' - ', $rows, "\r\n";
    }
    $cost = random_int(99, 9999) / 100;
    $amount = random_int(1, 200);
    $line = sprintf('"Item %d","description for item %d",%f0.02,%d;', $rows, $rows, $cost, $amount);
    fwrite($fh, $line . "\r\n");
}
fclose($fh);
echo $filename, ' has ', filesize($filename), " bytes.\r\n";
