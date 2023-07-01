<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Faker\Factory as FakerFactory;

class Helper
{
    public static function gerarCodigoBarras(): string
    {
        $codigoBarras = '';

        for ($i = 0; $i < 44; $i++) {
            $codigoBarras .= mt_rand(0, 9);
        }

        return $codigoBarras;
    }

    public static function fakeCsvData(): void
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
    }
}
