<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

class ExcelUploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('excel_file', FileType::class, [
            'label' => 'Excel file',
            'mapped' => false,
            'required' => true,
            'attr' => [
                'accept' => $this->getAcceptedExtensions(),
            ],
            'constraints' => [
                new File([
                    'maxSize' => '8M',
                    'mimeTypes' => $this->getAcceptedMimeTypes(),
                    'mimeTypesMessage' => 'Please upload a valid excel file',
                ])
            ],
        ]);
    }

    private function getAcceptedExtensions(): string
    {
        $extensions = [ 'xls', 'xlsx', 'xlsm',];

        return '.'.implode(',.', $extensions);
    }

    private function getAcceptedMimeTypes(): array
    {
        return [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-excel.sheet.macroEnabled.12',
        ];
    }
}
