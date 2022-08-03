<?php

namespace Database\Seeders;

use App\Models\ModelTaskStatus;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aStatuses = [
            [
                'status_name' => 'Todo', //Todo
            ],
            [
                'status_name' => 'Completed', //Completed
            ],
        ];

        foreach ($aStatuses as $aStatus) {
            ModelTaskStatus::query()->updateOrCreate($aStatus);
        }
    }
}
