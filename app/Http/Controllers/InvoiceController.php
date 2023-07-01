<?php

namespace App\Http\Controllers;

use App\Interfaces\EmailSenderServiceInterface;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Interfaces\InvoiceServiceInterface;
use App\Models\Debt;
use App\Models\Invoice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InvoiceController extends Controller
{
    private $invoiceRepository;
    private $invoiceService;
    private $emailSenderService;

    public function __construct(
        InvoiceRepositoryInterface $invoiceRepository,
        InvoiceServiceInterface $invoiceService,
        EmailSenderServiceInterface $emailSenderService
    ) {
        $this->invoiceRepository = $invoiceRepository;
        $this->invoiceService = $invoiceService;
        $this->emailSenderService = $emailSenderService;
    }

    public function generateInvoice(Request $request): Response
    {
        $debtId = $request->debtId;
        $dueDate = $request->dueDate;

        try {
            $debt = Debt::find($debtId);
            if ($debt) {
                $invoice = $this->invoiceService->generateInvoice($debt, $dueDate);
                if ($invoice) {
                    $this->emailSenderService->sendEmail($invoice);
                } else {
                    return Response("Invoice not generated: something went wrong", 400);
                }

            } else {
                return Response("Invoice not generated: Debt not found.", 400);
            }

            return Response("Invoice generated successfully");
        } catch(Exception $e) {
            return Response("Erro: ".$e->getMessage(), 400);
        }
    }

    public function receivePayment(Request $request): Response
    {
        $params = $request->all();

        $debtId = intval($request->debtId);
        $paidAt = $request->paidAt;
        $paidAmount = $request->paidAmount;
        $paidBy = $request->paidBy;

        // Validar infos

        $debt = Invoice::where("debt_id",$debtId)->first();

        if ($debt) {
            $this->invoiceService->identifyPayment($debt, $paidAt, $paidAmount);
            return new Response('Payment processed successfully');
        } else {
            return new Response('Débito não encontrado', 400);
        }


    }

}
