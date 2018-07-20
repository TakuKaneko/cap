<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorpusClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corpus_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('corpus_id');
            $table->double('threshold');
            $table->string('training_data_count');
            $table->string('test_data_count');
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
        Schema::dropIfExists('corpus_classes');
    }
}
