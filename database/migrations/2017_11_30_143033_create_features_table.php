<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('featured_id', 36);
            $table->string('featured_type', 255);
            $table->string('bucket_key')->index();
            $table->integer('position')->unsigned();
            $table->timestamps();
            $table->unique(['featured_id', 'featured_type', 'bucket_key'], 'features_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');
    }
}
