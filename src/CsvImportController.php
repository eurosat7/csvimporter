<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter;

class CsvImportController
{
    public function __construct(
        private readonly EntityRepository       $entityRepository,
        private readonly FileTools              $fileTools,
        private readonly FileToEntitysConverter $fileToEntitysConverter,
    )
    {
    }

    public function process(?string $filename): void
    {
        $lines = $this->fileTools->lineCountOfFile($filename);
        if ($filename === null || $lines === 0) {
            echo "no file was uploaded.", "\r\n";

            return;
        }
        echo "file was uploaded with ", $lines, " lines. reading:", "\r\n";

        $imported = $this->fileToEntitysConverter->processFile($filename, $this->entityRepository);
        echo "\r\n", "imported ", $imported, " entities.", "\r\n";
    }
}