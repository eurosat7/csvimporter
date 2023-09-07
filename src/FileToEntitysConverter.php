<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter;

class FileToEntitysConverter
{
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function processFile(string $filename, EntityRepository $entityRepository): int
    {
        $entityRepository->transactionBegin();
        $started = microtime(true);
        $skipFirstLine = true;
        $stream = fopen($filename, "rb");
        if ($stream === false) {
            echo "cannot read.";
            return 0;
        }
        $lineNo = 0;
        $imported = 0;
        while (!feof($stream)) {
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
            $entity = new Entity(
                name: $line[0],
                description: $line[1],
                cost: (float)$line[2],
                amount: (int)$line[3],
            );
            $success = $entityRepository->save($entity);
            $imported += $success ? 1 : 0;
            echo $success ? "+" : "-";
            if ($lineNo % 100 === 0) {
                echo " - ", $lineNo, "\r\n";
                flush();
                if (connection_aborted() !== 0) {
                    return 0;
                }
            }
        }
        echo $lineNo, "\r\n";
        fclose($stream);
        $entityRepository->transactionCommit();
        $duration = microtime(true) - $started;
        echo "\r\nduration: ", $duration, " sec.\r\n";

        return $imported;
    }
}
