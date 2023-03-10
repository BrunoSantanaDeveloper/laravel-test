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
        Schema::create('profile_report', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_id');
            $table->unsignedBigInteger('report_id');
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile_report');
    }
};
