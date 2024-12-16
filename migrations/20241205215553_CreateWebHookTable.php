<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Phpmig\Migration\Migration;

class CreateWebHookTable extends Migration
{
    /**
     * Выполните миграцию
     */
    public function up(): void
    {
        Capsule::schema()->create('webhook', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->string('chat_id');
            $table->string('talk_id');
            $table->string('author_id');
            $table->text('message');
            $table->json('webhook');
            $table->json('headers');
            $table->timestamps();
        });
    }

    /**
     * Откат миграции
     */
    public function down(): void
    {
        Capsule::schema()->dropIfExists('webhook');
    }
}
