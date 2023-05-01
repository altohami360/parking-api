<?php

use App\Models\Zone;
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
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price_per_hour');
            $table->timestamps();
        });

        Zone::create(['name' => 'green', 'price_per_hour' => '30']);
        Zone::create(['name' => 'Yellow', 'price_per_hour' => '20']);
        Zone::create(['name' => 'red', 'price_per_hour' => '10']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
