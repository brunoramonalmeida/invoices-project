<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as FakerFactory;

use App\Interfaces\DebtServiceInterface;
use App\Interfaces\EmailSenderServiceInterface;

use App\Models\Debt;

class DebtController extends Controller
{
    private $debtService;
    private $emailSenderService;

    public function __construct(
        DebtServiceInterface $debtService,
        EmailSenderServiceInterface $emailSenderService
    ) {
        $this->debtService = $debtService;
        $this->emailSenderService = $emailSenderService;
    }

    public function processDebts(Request $request): Response
    {
        if ($request->hasFile('input')) {
            $csvData = $request->file('input');
            if ($csvData->isValid()) {

                $csvData = file_get_contents($csvData->path());

                $debts = $this->parseCsvData($csvData);

                $this->debtService->generateDebts($debts);

                return new Response('Debts processed successfully');
            }
        } else {
            return response()->json(['error' => 'Invalid CSV file'], 400);
        }
    }

    private function parseCsvData($csvData): array
    {
        $lines = explode("\n", $csvData);
        $debts = [];

        $lines = array_slice($lines, 1);

        foreach ($lines as $line) {
            $data = str_getcsv($line);

            if (count($data) >= 6) {
                $name = $data[0];
                $governmentId = $data[1];
                $email = $data[2];
                $debtAmount = floatval($data[3]);
                $debtDueDate = $data[4];
                $debtId = intval($data[5]);

                $debt = new Debt();
                $debt->id = $debtId;
                $debt->name = $name;
                $debt->governmentId = $governmentId;
                $debt->email = $email;
                $debt->debtAmount = $debtAmount;
                $debt->debtDueDate = $debtDueDate;
                $debts[] = $debt;
            }
        }

        return $debts;
    }

    public function generateFakeDebts()
    {
        $faker = FakerFactory::create();
        $csvData = "name,governmentId,email,debtAmount,debtDueDate,debtId\n";

        for ($i = 0; $i < 10; $i++) {
            $name = $faker->name;
            $governmentId = $faker->numerify('###########');
            $email = $faker->email;
            $debtAmount = $faker->randomFloat(2, 100, 1000);
            $debtDueDate = $faker->dateTimeBetween('now', '+1 year')->format('Y-m-d');
            $debtId = $faker->randomNumber(4);

            $csvData .= "$name,$governmentId,$email,$debtAmount,$debtDueDate,$debtId\n";
        }

        $filename = 'fake_debts.csv';
        Storage::disk('local')->put($filename, $csvData);

        return response()->download(storage_path("app/$filename"), $filename);
    }
}
