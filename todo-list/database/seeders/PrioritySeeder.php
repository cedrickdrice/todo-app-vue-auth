<?php

namespace Database\Seeders;

use App\Models\ModelTaskPriority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aPriorities = [
            [
                'priority_name' => 'Urgent',
            ],
            [
                'priority_name' => 'High',
            ],
            [
                'priority_name' => 'Normal',
            ],
            [
                'priority_name' => 'Low',
            ],
        ];

        foreach ($aPriorities as $aPriority) {
            ModelTaskPriority::query()->updateOrCreate($aPriority);
        }
    }
}
