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
        $mem_pre = round(memory_get_peak_usage() / 1024 / 1024 * 100) / 100;
        $lines = $this->fileTools->lineCountOfFile($filename);
        if ($filename === null || $lines === 0) {
            echo "no file was uploaded.", "\r\n";

            return;
        }
        echo "file was uploaded with ", $lines, " lines. reading:", "\r\n";

        $imported = $this->fileToEntitysConverter->processFile($filename, $this->entityRepository);
        echo "\r\n", "imported ", $imported, " entities.", "\r\n";
        $mem_post = round(memory_get_peak_usage() / 1024 / 1024 * 100) / 100;
        echo "\r\n", "memory usage (in MB) started at ", $mem_pre, " and went as high as ", $mem_post, "\r\n";
    }
}