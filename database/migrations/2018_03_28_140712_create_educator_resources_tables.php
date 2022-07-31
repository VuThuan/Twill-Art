<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEducatorResourcesTables extends Migration
{
    public function up()
    {
        Schema::create('educator_resources', function (Blueprint $table) {
            createDefaultTableFields($table, true, true, true, true);
            $table->string('title', 200)->nullable();
            $table->text('short_description')->nullable();
        });

        Schema::create('educator_resource_slugs', function (Blueprint $table) {
            createDefaultSlugsTableFields($table, 'educator_resource');
        });

        Schema::create('educator_resource_revisions', function (Blueprint $table) {
            createDefaultRevisionsTableFields($table, 'educator_resource');
        });
    }

    public function down()
    {
        Schema::dropIfExists('educator_resource_revisions');
        Schema::dropIfExists('educator_resource_slugs');
        Schema::dropIfExists('educator_resources');
    }
}
