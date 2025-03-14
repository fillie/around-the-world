<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 3)->unique();
            $table->string('capital')->nullable();
            $table->string('continent')->nullable()->index();
            $table->timestamps();
        });

        $jsonPath = database_path('data/countries.json');
        if (file_exists($jsonPath)) {
            $json = file_get_contents($jsonPath);
            $countries = json_decode($json, true);

            if (is_array($countries)) {

                $data = array_map(function ($country) {
                    return [
                        'name'       => $country['name'],
                        'code'       => $country['code'],
                        'capital'    => $country['capital'] ?? '',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $countries);

                DB::table('countries')->insert($data);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
