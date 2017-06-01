<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdverts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('store_id');

            $table->string('ml_id');
            $table->string('site_id');

            $table->string('title')->default('Descrição não identificada.');
            $table->string('subtitle')->nullable();

            $table->string('category_id')->nullable();

            $table->double('price')->nullable()->default(0);
            $table->double('base_price')->nullable()->default(0);
            $table->double('original_price')->nullable()->default(0);

            $table->double('initial_quantity')->nullable()->default(0);
            $table->double('available_quantity')->nullable()->default(0);
            $table->double('sold_quantity')->nullable()->default(0);

            $table->string('currency_id')->nullable();
            $table->string('buying_mode')->nullable();
            $table->string('listing_type_id')->nullable();
            $table->string('condition')->nullable();
            $table->string('accepts_mercadopago')->nullable();
            $table->boolean('free_shipping')->nullable();
            $table->string('status')->nullable();
            $table->boolean('automatic_relist')->nullable();

            $table->string('thumbnail')->nullable();
            $table->string('secure_thumbnail')->nullable();

            $table->dateTime('start_time')->nullable();
            $table->dateTime('stop_time')->nullable();
            $table->dateTime('date_created')->nullable();
            $table->dateTime('last_updated')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('adverts');
    }
}
