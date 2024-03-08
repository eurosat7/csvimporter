<?php

declare(strict_types=1);

namespace Eurosat7\Csvimporter\Services;

use Eurosat7\Csvimporter\Database\Entity\Product;
use Eurosat7\Csvimporter\Database\Repository\ProductRepository;

class FileToEntitysConverter
{
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function processFile(string $filename, ProductRepository $productRepository): int
    {
        $productRepository->transactionBegin();
        $started = microtime(true);
        $skipFirstLine = true;
        $stream = fopen($filename, 'rb');
        if ($stream === false) {
            echo 'cannot read.';

            return 0;
        }
        $lineNo = 0;
        $imported = 0;
        while (!feof($stream) && connection_aborted() === 0) {
            $line = fgetcsv($stream);
            if ($line === false) {
                continue;
            }
            if (count($line) < 4) {
                continue;
            }
            $lineNo++;
            if ($skipFirstLine) {
                $skipFirstLine = false;
                continue;
            }
            $entity = new Product(
                name: $line[0],
                description: $line[1],
                cost: (float) $line[2],
                amount: (int) $line[3],
            );
            $success = $productRepository->save($entity);
            $imported += $success ? 1 : 0;
            echo $success ? '+' : '-';
            if ($lineNo % 100 === 0) {
                echo ' - ', $lineNo, "\r\n";
                flush();
            }
        }
        echo $lineNo, "\r\n";
        fclose($stream);
        $productRepository->transactionCommit();
        $duration = microtime(true) - $started;
        echo "\r\nduration: ", $duration, " sec.\r\n";

        return $imported;
    }
}
