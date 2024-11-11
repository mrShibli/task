<?php

namespace Database\Seeders;

use App\Models\LogData;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['job1', 'job2', 'job3'];
        $statuses = ['success', 'fail'];

        for ($i = 0; $i < 1000; $i++) {
            LogData::create([
                'type' => $types[array_rand($types)],
                'status' => $statuses[array_rand($statuses)],
                'log_datetime' => Carbon::now()->subDays(rand(1, 180))
            ]);
        }
    }
}
