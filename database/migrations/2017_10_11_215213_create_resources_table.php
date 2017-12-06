<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('cortex.bookings.tables.resources'), function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->string('slug');
            $table->{$this->jsonable()}('name');
            $table->{$this->jsonable()}('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('price')->default('0.00');
            $table->char('unit', 1)->default('h');
            $table->string('currency', 3);
            $table->string('type')->nullable();
            $table->string('style')->nullable();
            $table->mediumInteger('sort_order')->unsigned()->default(0);
            $table->boolean('multiple_bookings_allowed')->default(false);
            $table->boolean('multiple_bookings_bypassed')->default(false);
            $table->mediumInteger('multiple_bookings_allocation')->unsigned()->nullable();
            $table->smallInteger('early_booking_limit')->unsigned()->nullable();
            $table->smallInteger('late_booking_limit')->unsigned()->nullable();
            $table->smallInteger('late_cancellation_limit')->unsigned()->nullable();
            $table->smallInteger('maximum_booking_length')->unsigned()->nullable();
            $table->smallInteger('minimum_booking_length')->unsigned()->nullable();
            $table->tinyInteger('booking_interval_limit')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('cortex.bookings.tables.resources'));
    }

    /**
     * Get jsonable column data type.
     *
     * @return string
     */
    protected function jsonable()
    {
        return DB::connection()->getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql'
               && version_compare(DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION), '5.7.8', 'ge')
            ? 'json' : 'text';
    }
}
