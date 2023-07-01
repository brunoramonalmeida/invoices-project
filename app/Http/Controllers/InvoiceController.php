<?php

namespace App\Http\Controllers;

use App\Interfaces\EmailSenderServiceInterface;
use App\Interfaces\InvoiceRepositoryInterface;
use App\Interfaces\InvoiceServiceInterface;
use App\Models\Debt;
use App\Models\Invoice;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use Exception;

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

    public function generateInvoices(Request $request): Response
    {
        if ($this->invoiceService->generateInvoices()) {
            return Response("Invoices generated successfully");
        } else {
            return Response("Error on trying generating invoices");
        }
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
        $validator = Validator::make($request->all(), [
            'debtId' => 'required|integer',
            'paidAt' => 'required|date',
        ]);

        if ($validator->fails()) {
            return new Response($validator->errors()->first(), 400);
        }

        try {
            $debtId = intval($request->debtId);
            $paidAt = $request->paidAt;
            $paidAmount = $request->paidAmount;
            $paidBy = $request->paidBy;

            $debt = Invoice::where("debt_id",$debtId)->first();

            if ($debt) {
                if ($this->invoiceService->identifyPayment($debt, $paidAt, $paidAmount)) {
                    return new Response('Payment processed successfully');
                } else {
                    return new Response('Payment not processed', 400);
                }

            } else {
                return new Response('Debt not found', 400);
            }
        } catch(Exception $e) {
            return Response("Error: ".$e->getMessage(), 400);
        }
    }

}
