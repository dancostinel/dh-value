<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\ExcelUploadType;
use App\Service\ExcelListService;
use App\Service\ExcelSaveService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExcelController extends AbstractController
{
    #[Route('/list', name: 'excel_list_route', methods: ['GET', 'POST'])]
    public function list(
        Request $request,
        LoggerInterface $logger,
        ExcelSaveService $excelSaveService,
        ExcelListService $excelListService,
    ): Response {
        $form = $this->createForm(ExcelUploadType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $uploadedExcelFile = $form->get('excel_file')->getData();
                $excelSaveService->save($uploadedExcelFile);
                $this->addFlash('success', 'Excel file was successfully saved');
            } catch (\Exception $exception) {
                $logger->error(__METHOD__.': '.$exception->getMessage());
                $this->addFlash('error', 'Excel file was not saved');
            }

            return $this->redirectToRoute('excel_list_route');
        }

        return $this->render('list.html.twig', [
            'form' => $form->createView(),
            'files' => $excelListService->getExcelFiles(),
        ]);
    }
}