<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = User::query()->first()->id;

        $orderStatuses = ['pending' , 'rejected' , 'approved'];


        for($i = 0 ; $i <= 10 ; $i++){
            Order::query()->create([
                'user_id' => $userId,
                'course_id' => Course::inRandomOrder()->first()->id,
                'status' => $orderStatuses[array_rand($orderStatuses)]
            ]);
        }
    }
}
