<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteSelectionSelectionTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('selection_selection');
    }

    public function down()
    {
        Schema::create('selection_selection', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('selection_id')->unsigned();
            $table->foreign('selection_id')->references('id')->on('selections')->onDelete('cascade');
            $table->integer('related_selection_id')->unsigned();
            $table->foreign('related_selection_id')->references('id')->on('selections')->onDelete('cascade');
            $table->index(['related_selection_id', 'selection_id']);

            $table->integer('position')->unsigned()->index();
        });
    }
}
