<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEventTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('cortex.bookings.tables.tickets'), function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->string('slug');
            $table->{$this->jsonable()}('name');
            $table->{$this->jsonable()}('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('price')->default('0.00');
            $table->string('currency', 3)->nullable();
            $table->integer('quantity')->nullable();
            $table->mediumInteger('sort_order')->unsigned()->default(0);
            $table->auditableAndTimestamps();
            $table->softDeletes();

            // Indexes
            $table->unique(['event_id', 'slug']);
            $table->foreign('event_id')->references('id')->on(config('cortex.bookings.tables.events'))
                  ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('cortex.bookings.tables.tickets'));
    }
}
