<?php

use Carbon\Carbon;
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
        Schema::create('basic_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->dateTimeTz('expires_at')->default(Carbon::now()->addMonth());
            $table->dateTimeTz('last_used_at')->default(Carbon::now());
            $table->softDeletes();
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
        Schema::dropIfExists('basic_access_tokens');
    }
};
