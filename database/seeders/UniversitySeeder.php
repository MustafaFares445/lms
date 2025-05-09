<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample universities
        $universities = [
            ['name' => 'Harvard University'],
            ['name' => 'Stanford University'],
            ['name' => 'Massachusetts Institute of Technology'],
            ['name' => 'University of Cambridge'],
            ['name' => 'University of Oxford'],
        ];

        // Insert universities into the database
        foreach ($universities as $university) {
            University::create($university);
        }
    }
}