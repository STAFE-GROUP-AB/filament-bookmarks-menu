<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('filament_bookmarks_menu_table', function (Blueprint $table) {
            $table->id();
            $table->string('menu_label');
            $table->string('menu_url');
            $table->string('menu_target')->default('_self')->nullable();
            $table->integer('sort_order')->default(0);
            $table->foreignIdFor(\App\Models\User::class, 'menu_user_id')->nullable();
            $table->timestamps();
        });
    }
};
