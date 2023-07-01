<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Interfaces\DebtServiceInterface;
use App\Interfaces\EmailSenderServiceInterface;

use App\Models\Debt;
use Illuminate\Support\Facades\Log;

class DebtController extends Controller
{
    private $debtService;

    public function __construct(
        DebtServiceInterface $debtService
    ) {
        $this->debtService = $debtService;
    }

    public function processDebts(Request $request): Response
    {
        if ($request->hasFile('input')) {
            $csvData = $request->file('input');
            if ($csvData->isValid()) {
                try {
                    $csvData = file_get_contents($csvData->path());
                    $debts = $this->debtService->parseCsvData($csvData);
                } catch (\Exception $e) {
                    Log::error('Failed to try parsing CSV data: ' . $e->getMessage());
                    return false;
                }

                if ($this->debtService->generateDebts($debts)) {
                    return new Response('Debts processed successfully');
                } else {
                    return new Response('Error on try generating debts', 400);
                }
            }
        }
        return new Response('Invalid CSV file', 400);
    }

    public function generateFakeDebts()
    {
        try {
            Helper::fakeCsvData();
        } catch (\Exception $e) {
            Log::error('Failed to try generating fake CSV data: ' . $e->getMessage());
            return false;
        }

        return Response("CSV generated successfully");
    }
}
