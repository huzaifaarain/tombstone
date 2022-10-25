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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("image");
            $table->foreignId("tombstone_id")->constrained('tombstones');
            $table->string("name");
            $table->foreignId("font_id")->constrained('fonts');
            $table->foreignId("text_color_id")->constrained('text_colors');
            $table->date("date_of_birth");
            $table->date("death_date");
            $table->foreignId("icon_id")->constrained('icons');
            $table->unsignedDouble("price");
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
        Schema::dropIfExists('orders');
    }
};
