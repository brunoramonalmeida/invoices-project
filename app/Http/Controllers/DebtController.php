<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Interfaces\DebtRepositoryInterface;
use App\Interfaces\InvoiceServiceInterface;
use App\Interfaces\EmailSenderServiceInterface;

use App\Models\Debt;


class DebtController extends Controller
{
    private $debtRepository;
    private $invoiceGeneratorService;
    private $emailSenderService;

    public function __construct(
        DebtRepositoryInterface $debtRepository,
        InvoiceServiceInterface $invoiceGeneratorService,
        EmailSenderServiceInterface $emailSenderService
    ) {
        $this->debtRepository = $debtRepository;
        $this->invoiceGeneratorService = $invoiceGeneratorService;
        $this->emailSenderService = $emailSenderService;
    }

    public function processDebts(Request $request): Response
    {
        $csvData = $request->getContent();
        $debts = $this->parseCsvData($csvData);

        foreach ($debts as $debtData) {
            $debt = new Debt(
                $debtData['name'],
                $debtData['governmentId'],
                $debtData['email'],
                $debtData['debtAmount'],
                $debtData['debtDueDate'],
                $debtData['debtId']
            );

            $this->invoiceGeneratorService->generateInvoice($debt);

            $this->emailSenderService->sendEmail($debt);
        }

        return new Response('Debts processed successfully');
    }

    private function parseCsvData(string $csvData): array
    {
        // Lógica para analisar os dados do CSV e retornar um array de dívidas
        return [];
    }
}
