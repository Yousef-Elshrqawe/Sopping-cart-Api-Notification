<?php

use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('use_times')->nullable();             # how many times this offer can be used
            $table->unsignedBigInteger('used_times')->default(0);      # how many times this coupon has been used
            $table->unsignedBigInteger('user_times')->default(0);      # how many times this coupon has been used by the user
            $table->unsignedBigInteger('amount')->unsigned();               # amount of discount
            $table->boolean('amount_type')->comment('0 => $, 1 => %');                                 # 0 => $, 1 => %
            $table->dateTime('start_date')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->unsignedDecimal('greater_than')->nullable();            # greater than this amount
            $table->boolean('status')->default(false);                 #
            $table->timestamps();
        });
        Offer::create([

            'use_times' => 10,
            'used_times' => 0,
            'amount' => 10,
            'user_times' => 3,
            'amount_type' => 0,
            'start_date' => Carbon::now(),
            'expire_date' => Carbon::now()->addDays(30),
            'greater_than' => 30,
            'status' => true,
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
