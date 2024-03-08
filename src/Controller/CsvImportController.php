<?php

declare(strict_types=1);

namespace Eurosat7\Csvimporter\Controller;

use Eurosat7\Csvimporter\Database\Repository\ProductRepository;
use Eurosat7\Csvimporter\Services\FileToEntitysConverter;
use Eurosat7\Csvimporter\Services\FileTools;

class CsvImportController implements CanProcess
{
    private ?string $filename = null;

    public function __construct(
        readonly private ProductRepository $productRepository,
        readonly private FileTools $fileTools,
        readonly private FileToEntitysConverter $fileToEntitysConverter,
    ) {
    }

    public function setFile(?string $filename): void
    {
        $this->filename = $filename;
    }

    public function process(): void
    {
        $memPre = round(memory_get_peak_usage() / 1024 / 1024 * 100) / 100;
        $lines = $this->fileTools->lineCountOfFile($this->filename);
        if ($this->filename === null || $lines === 0) {
            echo 'no file was uploaded.', "\r\n";

            return;
        }
        echo 'file was uploaded with ', $lines, ' lines. reading:', "\r\n";

        $imported = $this->fileToEntitysConverter->processFile($this->filename, $this->productRepository);
        echo "\r\n", 'imported ', $imported, ' entities.', "\r\n";
        $memPost = round(memory_get_peak_usage() / 1024 / 1024 * 100) / 100;
        echo "\r\n", 'memory usage (in MB) started at ', $memPre, ' and went as high as ', $memPost, "\r\n";
    }
}
