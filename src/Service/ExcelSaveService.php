<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

readonly class ExcelSaveService
{
    public function __construct(private SluggerInterface $slugger, private string $excelDirectory)
    {
    }

    /**
     * @throws FileException
     */
    public function save(UploadedFile $file): void
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid('', true).'.'.$file->guessExtension();
        $file->move($this->excelDirectory, $newFilename);
    }
}
