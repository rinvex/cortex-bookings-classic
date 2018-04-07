<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEventTicketing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('cortex.bookings.tables.ticketing'), function (Blueprint $table) {
            // Columns
            $table->integer('ticket_id')->unsigned();
            $table->integer('member_id')->unsigned();
            $table->decimal('paid')->default('0.00');
            $table->string('currency', 3)->nullable();
            $table->text('notes')->nullable();
            $table->auditableAndTimestamps();
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
        Schema::dropIfExists(config('cortex.bookings.tables.ticketing'));
    }
}
