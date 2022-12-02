<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('cart_token')->nullable();
            $table->string('key');
            $table->unsignedBigInteger( 'user_id' ) -> unsigned() -> index()->nullable();
            $table->foreign( 'user_id' ) -> references( 'id' ) -> on( 'users')-> onDelete( 'cascade' );
            $table->nullableTimestamps();


        });
    }

    /**Failed to open stream: No such file or directory

     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
};
