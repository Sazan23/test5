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
            $table->increments('record_id');
            $table->integer('file_id')->unsigned();
            $table->string('record_name');
            $table->string('record_phone');
            $table->string('record_email');
            $table->string('record_date');
            $table->string('record_company');
            $table->string('record_city');
            $table->string('record_region');
            $table->string('record_guid');
            $table->timestamps();
        });

        Schema::table('records', function(Blueprint $table) {
            $table->foreign('file_id')->references('file_id')->on('files')
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
