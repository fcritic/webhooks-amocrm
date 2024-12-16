<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Phpmig\Migration\Migration;

class CreateErrorTable extends Migration
{
    /** Выполните миграцию */
    public function up(): void
    {
        Capsule::schema()->create('error', function (Blueprint $table) {
            $table->increments('id');
            $table->json('request');
            $table->json('headers');
            $table->timestamps();
        });
    }

    /** Откат миграции */
    public function down(): void
    {
        Capsule::schema()->dropIfExists('error');
    }
}
