<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create(config('loggable.table'), function (Blueprint $table) {
            $table->bigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('user_id');
            $table->morphs('model');
            $table->string('type');
            $table->string('table');
            $table->longText('payload')->nullable();
            $table->dateTime('log_at');

            // index colums
            $table->foreign('user_id')
                  ->references(app()->make(config('auth.providers.users.model'))->getKeyName())
                  ->on(app()->make(config('auth.providers.users.model'))->getTable());

          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('loggable.table'));
    }
}
