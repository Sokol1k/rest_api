<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned()->autoIncrement();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('name', 150)->nullable(false);
            $table->string('url', 255)->unique()->nullable(false);
            $table->string('description', 500)->nullable();
            $table->string('category', 50)->nullable();
            $table->float('rating')->nullable();
            $table->integer('rating_buildzoom')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('website', 255)->nullable();
            $table->boolean('is_licensed')->default(false);
            $table->longText('license_info')->nullable();
            $table->string('insured_value', 50)->nullable();
            $table->string('bond_value', 50)->nullable();
            $table->string('street_address', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 10)->nullable();
            $table->string('zipcode', 20)->nullable();
            $table->string('full_address', 130)->nullable();
            $table->string('image', 255)->nullable();
            $table->longText('employee')->nullable();
            $table->longText('work_preferences')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('businesses');
    }
}
