<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Finder\Finder;

readonly class ExcelListService
{
    public function __construct(private string $excelDirectory)
    {
    }

    public function getExcelFiles(): array
    {
        $finder = new Finder();
        $finder->files()->in($this->excelDirectory);

        if (!$finder->hasResults()) {
            return [];
        }

        foreach ($finder as $file) {
            $foundFiles[] = $file;
        }

        return $foundFiles ?? [];
    }
}
