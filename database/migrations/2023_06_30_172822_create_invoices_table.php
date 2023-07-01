<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Debt;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->double("amount");
            $table->date("due_date");
            $table->integer("payment_status")->defaultValue(0);
            $table->string('beneficiary_name');
            $table->string('beneficiary_document');
            $table->string('beneficiary_bank_account');
            $table->string('payer_name');
            $table->string('payer_document');
            $table->string('payer_address');
            $table->string('document_number');
            $table->dateTime("paid_at")->nullable();
            $table->double("paid_amount")->nullable();
            $table->foreignIdFor(Debt::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
