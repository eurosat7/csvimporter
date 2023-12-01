<?php
declare(strict_types=1);

namespace Eurosat7\Csvimporter\Services;

class FileTools
{
    public function lineCountOfFile(?string $filename): int
    {
        $lines = 0;
        if ($filename === null) {
            return 0;
        }
        if (!file_exists($filename)) {
            return 0;
        }
        $stream = fopen($filename, "rb");
        if ($stream === false) {
            return 0;
        }
        while (!feof($stream)) {
            fgets($stream);
            $lines++;
        }

        fclose($stream);

        return $lines;
    }
}
