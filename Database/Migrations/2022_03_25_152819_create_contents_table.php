<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\PageBuilder\Enum\ContentStatus;
use Modules\PageBuilder\Utils\Table;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Table::contents(), function (Blueprint $table) {
            $table->id();
            $table->morphs('contentable');
            $table->string('status')->default(ContentStatus::Draft->value)->index();
            $table->unsignedInteger('read_time')->nullable();
            $table->json('data')->nullable();
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
        Schema::dropIfExists(Table::contents());
    }
};
