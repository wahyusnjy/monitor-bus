<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bus_route_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('route_id');
            $table->time('schedule_start');
            $table->time('schedule_end');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['bus_id', 'is_active']);
            $table->index(['route_id', 'is_active']);
            
            $table->foreign('bus_id')
                ->references('id')
                ->on('buses')
                ->onDelete('cascade');
                
            $table->foreign('route_id')
                ->references('id')
                ->on('routes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('s');
    }
};
