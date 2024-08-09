<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('availability', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('monday')->default(false)->nullable();
            $table->boolean('tuesday')->default(false)->nullable();
            $table->boolean('wednesday')->default(false)->nullable();
            $table->boolean('thursday')->default(false)->nullable();
            $table->boolean('friday')->default(false)->nullable();
            $table->boolean('saturday')->default(false)->nullable();
            $table->boolean('sunday')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('availability');
    }
};
