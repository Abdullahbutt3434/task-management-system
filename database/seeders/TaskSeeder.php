<?php

namespace Database\Seeders;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::create([
            'name' => 'Documentation',
            'priority' => 1,
            'start' => Carbon::now(),
            'end' => Carbon::now(),
            'user_id' => 1
        ]);
        Task::create([
            'name' => 'Testing',
            'priority' => 2,
            'start' => Carbon::now(),
            'end' => Carbon::now(),
            'user_id' => 1
        ]);
        Task::create([
            'name' => 'Deployment',
            'priority' => 1,
            'start' => Carbon::now(),
            'end' => Carbon::now(),
            'user_id' => 2
        ]);
        Task::create([
            'name' => 'Requirement Verification',
            'priority' => 2,
            'start' => Carbon::now(),
            'end' => Carbon::now(),
            'user_id' => 2
        ]);
        Task::create([
            'name' => 'Developement',
            'priority' => 1,
            'start' => Carbon::now(),
            'end' => Carbon::now(),
            'user_id' => 3
        ]);
    }
}
