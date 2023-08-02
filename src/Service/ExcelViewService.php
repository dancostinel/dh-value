<?php

declare(strict_types=1);

namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class ExcelViewService
{
    public function __construct(private string $excelDirectory)
    {
    }

    /**
     * @throws NotFoundHttpException
     * @throws \InvalidArgumentException
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function view(string $filename): void
    {
        $finder = new Finder();
        $finder->files()->in($this->excelDirectory)->name($filename);
        if (!$finder->hasResults()) {
            throw new NotFoundHttpException('File '.$filename.' was not found');
        }

        if (1 < count($finder)) {
            throw new \InvalidArgumentException('Invalid excel file sent');
        }

        foreach ($finder as $file) {
            $reader = IOFactory::createReaderForFile($file->getPathname());
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getPathname());
        }

        if (null === ($spreadsheet ?? null)) {
            throw new \RuntimeException('Excel file could not be created. Please try again later.');
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Html');
        $writer->save('php://output');
    }
}
