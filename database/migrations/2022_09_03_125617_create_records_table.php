<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_id')->unsigned();
            $table->string('record_name');
            $table->string('record_phone')->nullable();
            $table->string('record_email')->nullable();
            $table->date('record_date')->nullable();
            $table->string('record_company')->nullable();
            $table->string('record_city')->nullable();
            $table->string('record_region')->nullable();
            $table->string('record_img')->nullable();
            $table->timestamps();
        });

        Schema::table('records', function(Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files')
                        ->onDelete('restrict')
                        ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');

        Schema::table('records', function(Blueprint $table) {
            $table->dropForeign('records_file_id_foreign');
        });
    }
}
